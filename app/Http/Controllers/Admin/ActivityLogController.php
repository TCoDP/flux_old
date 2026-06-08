<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $logs = ActivityLog::with('user')
            ->when($request->string('q')->toString(), fn ($q, $s) => $q->where('action', 'like', "%{$s}%")
                ->orWhere('description', 'like', "%{$s}%"))
            ->latest()
            ->paginate(30)
            ->withQueryString();

        return view('admin.logs.index', ['logs' => $logs]);
    }
}
