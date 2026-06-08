<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\SettingsService;
use Illuminate\Http\JsonResponse;

class MetaController extends Controller
{
    /** Public project metadata used by the Telegram bot and other clients. */
    public function index(SettingsService $settings): JsonResponse
    {
        return response()->json([
            'data' => [
                'site_name' => $settings->get('site_name'),
                'tagline' => $settings->get('site_tagline'),
                'support_email' => $settings->get('support_email'),
                'support_telegram' => $settings->get('support_telegram'),
                'site_url' => rtrim((string) config('app.url'), '/'),
            ],
        ]);
    }
}
