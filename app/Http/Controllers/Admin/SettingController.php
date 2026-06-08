<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingsService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /** Keys editable from the admin settings screen. */
    private const KEYS = [
        'site_name', 'site_tagline', 'support_email', 'support_telegram', 'support_phone',
        'company_legal', 'company_inn', 'servers_count', 'regions_count', 'users_count', 'uptime',
    ];

    public function edit(SettingsService $settings): View
    {
        return view('admin.settings', ['settings' => $settings->all(), 'keys' => self::KEYS]);
    }

    public function update(Request $request, SettingsService $settings): RedirectResponse
    {
        $data = $request->validate(array_fill_keys(
            array_map(fn ($k) => $k, self::KEYS),
            ['nullable', 'string', 'max:255'],
        ));

        foreach (self::KEYS as $key) {
            $settings->set($key, $data[$key] ?? '');
        }

        return back()->with('status', __('admin.saved'));
    }
}
