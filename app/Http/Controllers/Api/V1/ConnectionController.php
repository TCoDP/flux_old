<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Connection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $connections = $request->user()->connections()->with('server.region')->get()
            ->map(fn (Connection $c) => [
                'uuid' => $c->uuid,
                'name' => $c->name,
                'status' => $c->status->value,
                'region' => $c->server?->region?->name,
                'last_handshake_at' => $c->last_handshake_at?->toAtomString(),
            ]);

        return response()->json(['data' => $connections]);
    }

    public function show(Request $request, Connection $connection): JsonResponse
    {
        abort_unless($connection->user_id === $request->user()->id, 403);

        return response()->json([
            'data' => [
                'uuid' => $connection->uuid,
                'name' => $connection->name,
                'status' => $connection->status->value,
                'access_token' => $connection->access_token,
                'region' => $connection->server?->region?->name,
                'traffic' => [
                    'up' => $connection->bytes_up,
                    'down' => $connection->bytes_down,
                ],
            ],
        ]);
    }
}
