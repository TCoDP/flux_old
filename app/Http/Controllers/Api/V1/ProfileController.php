<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();
        $subscription = $user->activeSubscription()?->load('plan');

        return response()->json([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'locale' => $user->locale,
                'balance' => (float) $user->balance,
                'subscription' => $subscription ? [
                    'plan' => $subscription->plan->name,
                    'status' => $subscription->status->value,
                    'ends_at' => $subscription->ends_at?->toAtomString(),
                    'days_left' => $subscription->daysLeft(),
                ] : null,
                'referral' => [
                    'code' => $user->referral_code,
                    'link' => route('register', ['locale' => $user->locale ?: 'ru', 'ref' => $user->referral_code]),
                    'invited' => $user->referralsMade()->count(),
                ],
            ],
        ]);
    }
}
