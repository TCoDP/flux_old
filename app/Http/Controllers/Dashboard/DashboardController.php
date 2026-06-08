<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('dashboard.home', [
            'subscription' => $user->activeSubscription()?->load('plan'),
            'devicesCount' => $user->devices()->count(),
            'connectionsCount' => $user->connections()->where('status', 'active')->count(),
            'connections' => $user->connections()->with('server.region')->latest()->take(3)->get(),
            'payments' => $user->payments()->latest()->take(5)->get(),
            'notifications' => $user->notifications()->take(5)->get(),
            'unreadCount' => $user->unreadNotificationsCount(),
        ]);
    }
}
