<?php

namespace App\Services;

use App\Enums\ConnectionStatus;
use App\Enums\ServerStatus;
use App\Models\Connection;
use App\Models\Device;
use App\Models\Server;
use App\Models\Subscription;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ConnectionProvisioner
{
    public function __construct(private readonly PanelService $panel) {}

    /**
     * Create a new secure-access profile for a subscription. When a 3X-UI panel
     * is configured, a real Xray client is created and its import link stored;
     * otherwise a local demo profile is produced.
     */
    public function provision(Subscription $subscription, ?Device $device = null, ?string $name = null): Connection
    {
        $server = $this->pickServer();

        $connection = Connection::create([
            'user_id' => $subscription->user_id,
            'subscription_id' => $subscription->id,
            'server_id' => $server?->id,
            'device_id' => $device?->id,
            'name' => $name ?? __('dashboard.connections.default_name'),
            'status' => ConnectionStatus::Active,
        ]);

        if ($this->panel->enabled()) {
            $this->provisionOnPanel($connection, $subscription);
        }

        return $connection;
    }

    /** Ensure a subscription has at least one connection and keep panel expiry in sync. */
    public function ensureForSubscription(Subscription $subscription): void
    {
        if ($subscription->connections()->count() === 0) {
            $this->provision($subscription);

            return;
        }

        if (! $this->panel->enabled() || ! $subscription->ends_at) {
            return;
        }

        foreach ($subscription->connections()->whereNotNull('remote_email')->get() as $connection) {
            $this->syncExpiry($connection, $subscription);
        }
    }

    private function provisionOnPanel(Connection $connection, Subscription $subscription): void
    {
        try {
            $email = 'flx-'.$subscription->user_id.'-'.Str::lower(Str::random(8));
            $expiryMs = $subscription->ends_at ? (int) ($subscription->ends_at->timestamp * 1000) : 0;

            $this->panel->addClient($email, $expiryMs, (int) config('services.xui.default_bytes', 0));

            $client = $this->panel->getClient($email);
            $links = $this->panel->getLinks($email);
            $subId = $client['subId'] ?? null;

            $connection->forceFill([
                'remote_email' => $email,
                'sub_id' => $subId,
                'config_link' => $links[0] ?? null,
                'subscription_url' => $this->panel->subscriptionUrl($subId),
            ])->save();
        } catch (\Throwable $e) {
            Log::warning('[xui] provision failed for subscription '.$subscription->id.': '.$e->getMessage());
        }
    }

    private function syncExpiry(Connection $connection, Subscription $subscription): void
    {
        try {
            $this->panel->updateClient($connection->remote_email, [
                'email' => $connection->remote_email,
                'enable' => true,
                'expiryTime' => $subscription->ends_at ? (int) ($subscription->ends_at->timestamp * 1000) : 0,
                'totalGB' => (int) config('services.xui.default_bytes', 0),
            ]);
        } catch (\Throwable $e) {
            Log::warning('[xui] expiry sync failed for connection '.$connection->id.': '.$e->getMessage());
        }
    }

    private function pickServer(): ?Server
    {
        return Server::query()
            ->active()
            ->where('status', ServerStatus::Online)
            ->orderByRaw('current_load / GREATEST(capacity, 1) asc')
            ->first();
    }
}
