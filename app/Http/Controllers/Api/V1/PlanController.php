<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\JsonResponse;

class PlanController extends Controller
{
    /** Public list of active plans (used by the marketing surfaces and the bot). */
    public function index(): JsonResponse
    {
        $plans = Plan::active()->get()->map(fn (Plan $plan) => [
            'name' => $plan->name,
            'slug' => $plan->slug,
            'tagline' => $plan->tagline,
            'price' => (float) $plan->price,
            'old_price' => $plan->old_price !== null ? (float) $plan->old_price : null,
            'currency' => $plan->currency,
            'period' => $plan->billing_period->value,
            'device_limit' => $plan->device_limit,
            'features' => $plan->features ?? [],
            'is_popular' => $plan->is_popular,
        ]);

        return response()->json(['data' => $plans]);
    }
}
