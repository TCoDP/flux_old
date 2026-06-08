<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Connection;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    public function index(Request $request): View
    {
        return view('dashboard.connections.index', [
            'connections' => $request->user()->connections()->with('server.region', 'device')->latest()->get(),
        ]);
    }

    public function show(Request $request, Connection $connection): View
    {
        abort_unless($connection->user_id === $request->user()->id, 403);

        return view('dashboard.connections.show', [
            'connection' => $connection->load('server.region', 'subscription.plan', 'device'),
        ]);
    }

    public function regenerate(Request $request, Connection $connection): RedirectResponse
    {
        abort_unless($connection->user_id === $request->user()->id, 403);

        $connection->regenerate();

        return back()->with('status', __('dashboard.connections.regenerated'));
    }
}
