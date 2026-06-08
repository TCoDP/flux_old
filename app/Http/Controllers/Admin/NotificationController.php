<?php

namespace App\Http\Controllers\Admin;

use App\Enums\NotificationType;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NotificationController extends Controller
{
    public function index(): View
    {
        return view('admin.notifications.index', [
            'recent' => Notification::with('user')->latest()->take(30)->get(),
            'sentCount' => Notification::count(),
        ]);
    }

    public function create(): View
    {
        return view('admin.notifications.create', ['types' => NotificationType::cases()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'body' => ['nullable', 'string', 'max:1000'],
            'type' => ['required', Rule::enum(NotificationType::class)],
            'audience' => ['required', 'in:all,subscribers'],
            'action_url' => ['nullable', 'url'],
        ]);

        $query = User::query()
            ->when($data['audience'] === 'subscribers', fn ($q) => $q->whereHas('subscriptions', fn ($s) => $s->live()));

        $count = 0;
        $query->select('id')->chunkById(500, function ($users) use ($data, &$count) {
            $rows = $users->map(fn ($u) => [
                'user_id' => $u->id,
                'type' => $data['type'],
                'title' => $data['title'],
                'body' => $data['body'] ?? null,
                'icon' => NotificationType::from($data['type'])->icon(),
                'action_url' => $data['action_url'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ])->all();

            Notification::insert($rows);
            $count += count($rows);
        });

        return redirect()->route('admin.notifications.index')
            ->with('status', __('admin.notifications.sent', ['count' => $count]));
    }
}
