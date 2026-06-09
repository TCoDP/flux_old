<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ActivityLogger;
use App\Services\BillingService;
use App\Services\ReferralService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    /** Register a new account straight from the bot and return a read-only token. */
    public function register(Request $request, ReferralService $referrals, BillingService $billing): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'referral_code' => ['nullable', 'string', 'max:32'],
            'telegram_id' => ['nullable', 'string', 'max:32', Rule::unique('users', 'telegram_id')],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'locale' => $request->input('locale') === 'en' ? 'en' : 'ru',
            'telegram_id' => $data['telegram_id'] ?? null,
            'email_verified_at' => now(), // verified via the bot identity
        ]);

        $referrals->attach($user, $data['referral_code'] ?? null);
        $billing->startTrial($user); // 2-week free trial on sign-up
        ActivityLogger::log('user.registered.telegram', user: $user);

        $token = $user->createToken('telegram-bot', ['read'])->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => ['name' => $user->name, 'email' => $user->email],
        ], 201);
    }

    /** Issue a read-only personal access token for the Telegram bot. */
    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:80'],
            'telegram_id' => ['nullable', 'string', 'max:32'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => __('auth.failed')], 422);
        }

        if ($user->isBanned()) {
            return response()->json(['message' => __('auth.banned')], 403);
        }

        // Link this account to the Telegram user the first time they sign in via the bot.
        if (! empty($data['telegram_id']) && empty($user->telegram_id)) {
            $user->forceFill(['telegram_id' => $data['telegram_id']])->save();
        }

        $token = $user->createToken($data['device_name'] ?? 'telegram-bot', ['read'])->plainTextToken;
        ActivityLogger::log('api.token.telegram', user: $user);

        return response()->json([
            'token' => $token,
            'user' => ['name' => $user->name, 'email' => $user->email],
        ]);
    }

    /** Recognise a returning Telegram user via the trusted bot channel. */
    public function telegram(Request $request): JsonResponse
    {
        $secret = (string) config('services.telegram_bot.secret');

        if ($secret === '' || ! hash_equals($secret, (string) $request->header('X-Bot-Secret'))) {
            return response()->json(['message' => 'forbidden'], 403);
        }

        $data = $request->validate(['telegram_id' => ['required', 'string', 'max:32']]);

        $user = User::where('telegram_id', $data['telegram_id'])->first();

        if (! $user) {
            return response()->json(['message' => 'not_registered'], 404);
        }

        if ($user->isBanned()) {
            return response()->json(['message' => __('auth.banned')], 403);
        }

        $token = $user->createToken('telegram-bot', ['read'])->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => ['name' => $user->name, 'email' => $user->email],
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json(['message' => 'ok']);
    }
}
