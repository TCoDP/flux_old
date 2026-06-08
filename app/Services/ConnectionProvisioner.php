<?php

namespace App\Services;

use App\Enums\ConnectionStatus;
use App\Enums\ServerStatus;
use App\Models\Connection;
use App\Models\Device;
use App\Models\Server;
use App\Models\Subscription;

class ConnectionProvisioner
{
    /**
     * Create a new secure-access profile for a subscription, attaching it to
     * the least-loaded online server.
     */
    public function provision(Subscription $subscription, ?Device $device = null, ?string $name = null): Connection
    {
        $server = $this->pickServer();

        return Connection::create([
            'user_id' => $subscription->user_id,
            'subscription_id' => $subscription->id,
            'server_id' => $server?->id,
            'device_id' => $device?->id,
            'name' => $name ?? __('dashboard.connections.default_name'),
            'status' => ConnectionStatus::Active,
        ]);
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
