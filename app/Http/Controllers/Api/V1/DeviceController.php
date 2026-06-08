<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $devices = $request->user()->devices()->get()
            ->map(fn (Device $d) => [
                'id' => $d->id,
                'name' => $d->name,
                'platform' => $d->platform->value,
                'last_seen_at' => $d->last_seen_at?->toAtomString(),
                'is_active' => $d->is_active,
            ]);

        return response()->json(['data' => $devices]);
    }
}
