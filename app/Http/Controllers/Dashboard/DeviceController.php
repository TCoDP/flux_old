<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\DevicePlatform;
use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $limit = $user->activeSubscription()?->plan?->device_limit ?? 0;

        return view('dashboard.devices.index', [
            'devices' => $user->devices()->latest()->get(),
            'limit' => $limit,
            'platforms' => DevicePlatform::cases(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'platform' => ['required', 'string', 'in:'.implode(',', DevicePlatform::values())],
        ]);

        $user = $request->user();
        $limit = $user->activeSubscription()?->plan?->device_limit ?? 0;

        if ($user->devices()->count() >= $limit) {
            return back()->withErrors(['name' => __('dashboard.devices.limit_reached')]);
        }

        $user->devices()->create($data + ['is_active' => true, 'last_seen_at' => now()]);

        return back()->with('status', __('dashboard.devices.added'));
    }

    public function destroy(Request $request, Device $device): RedirectResponse
    {
        abort_unless($device->user_id === $request->user()->id, 403);

        $device->delete();

        return back()->with('status', __('dashboard.devices.removed'));
    }
}
