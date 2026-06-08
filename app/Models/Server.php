<?php

namespace App\Models;

use App\Enums\ServerStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Server extends Model
{
    /** @use HasFactory<\Database\Factories\ServerFactory> */
    use HasFactory;

    protected $fillable = [
        'region_id', 'name', 'hostname', 'status',
        'capacity', 'current_load', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'status' => ServerStatus::class,
            'capacity' => 'integer',
            'current_load' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function connections(): HasMany
    {
        return $this->hasMany(Connection::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function loadPercent(): int
    {
        return $this->capacity > 0
            ? min(100, (int) round($this->current_load / $this->capacity * 100))
            : 0;
    }
}
