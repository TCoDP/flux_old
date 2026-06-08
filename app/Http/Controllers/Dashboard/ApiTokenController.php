<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ApiTokenController extends Controller
{
    public function index(Request $request): View
    {
        return view('dashboard.api-tokens', [
            'tokens' => $request->user()->tokens()->latest()->get(),
            'createdToken' => $request->session()->get('created_token'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['name' => ['required', 'string', 'max:80']]);

        $token = $request->user()->createToken($request->string('name'), ['read']);

        return back()
            ->with('created_token', $token->plainTextToken)
            ->with('status', __('dashboard.api.created'));
    }

    public function destroy(Request $request, string $token): RedirectResponse
    {
        $request->user()->tokens()->whereKey($token)->delete();

        return back()->with('status', __('dashboard.api.revoked'));
    }
}
