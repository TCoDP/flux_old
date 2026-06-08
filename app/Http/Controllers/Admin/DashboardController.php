<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentStatus;
use App\Enums\ServerStatus;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Server;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'usersCount' => User::count(),
            'activeSubscriptions' => Subscription::live()->count(),
            'revenue' => Payment::where('status', PaymentStatus::Paid)->sum('amount'),
            'pendingPayments' => Payment::where('status', PaymentStatus::Pending)->count(),
            'serversOnline' => Server::where('status', ServerStatus::Online)->count(),
            'serversTotal' => Server::count(),
            'recentUsers' => User::latest()->take(6)->get(),
            'recentPayments' => Payment::with('user', 'plan')->latest()->take(8)->get(),
            'revenueSeries' => Payment::where('status', PaymentStatus::Paid)
                ->where('created_at', '>=', now()->subDays(14))
                ->selectRaw('DATE(created_at) as day, SUM(amount) as total')
                ->groupBy('day')->orderBy('day')->pluck('total', 'day')->all(),
        ]);
    }
}
