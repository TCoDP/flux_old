<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $subscriptions = $request->user()->subscriptions()->with('plan')->latest()->get()
            ->map(fn (Subscription $s) => [
                'id' => $s->id,
                'plan' => $s->plan->name,
                'status' => $s->status->value,
                'starts_at' => $s->starts_at?->toAtomString(),
                'ends_at' => $s->ends_at?->toAtomString(),
                'auto_renew' => $s->auto_renew,
            ]);

        return response()->json(['data' => $subscriptions]);
    }

    public function show(Request $request, Subscription $subscription): JsonResponse
    {
        abort_unless($subscription->user_id === $request->user()->id, 403);

        return response()->json(['data' => $subscription->load('plan', 'connections')]);
    }
}
