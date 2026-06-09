<?php

namespace App\Models;

use App\Enums\ConnectionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Connection extends Model
{
    /** @use HasFactory<\Database\Factories\ConnectionFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id', 'subscription_id', 'server_id', 'device_id', 'name',
        'uuid', 'access_token', 'remote_email', 'sub_id', 'subscription_url', 'config_link',
        'status', 'last_handshake_at', 'bytes_up', 'bytes_down',
    ];

    protected function casts(): array
    {
        return [
            'status' => ConnectionStatus::class,
            'last_handshake_at' => 'datetime',
            'bytes_up' => 'integer',
            'bytes_down' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Connection $connection) {
            $connection->uuid ??= (string) Str::uuid();
            $connection->access_token ??= Str::random(48);
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function totalTraffic(): int
    {
        return $this->bytes_up + $this->bytes_down;
    }

    /** Whether this profile is backed by a real panel-issued config. */
    public function hasRealConfig(): bool
    {
        return filled($this->config_link);
    }

    /** The import link to show the user (real panel link, or a demo placeholder). */
    public function primaryLink(): string
    {
        if ($this->config_link) {
            return $this->config_link;
        }

        $host = $this->server?->hostname ?: 'msk-01.flux.net';

        return 'vless://'.$this->uuid.'@'.$host.':443?type=tcp&security=reality&fp=chrome#'.rawurlencode($this->name);
    }

    public function regenerate(): void
    {
        $this->update([
            'uuid' => (string) Str::uuid(),
            'access_token' => Str::random(48),
        ]);
    }
}
