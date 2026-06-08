<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ServerStatus;
use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\Server;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServerController extends Controller
{
    public function index(): View
    {
        return view('admin.servers.index', [
            'servers' => Server::with('region')->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.servers.create', [
            'regions' => Region::orderBy('name')->get(),
            'statuses' => ServerStatus::cases(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Server::create($this->validated($request));

        return redirect()->route('admin.servers.index')->with('status', __('admin.saved'));
    }

    public function edit(Server $server): View
    {
        return view('admin.servers.edit', [
            'server' => $server,
            'regions' => Region::orderBy('name')->get(),
            'statuses' => ServerStatus::cases(),
        ]);
    }

    public function update(Request $request, Server $server): RedirectResponse
    {
        $server->update($this->validated($request));

        return redirect()->route('admin.servers.index')->with('status', __('admin.saved'));
    }

    public function destroy(Server $server): RedirectResponse
    {
        $server->delete();

        return back()->with('status', __('admin.deleted'));
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'region_id' => ['required', 'exists:regions,id'],
            'name' => ['required', 'string', 'max:120'],
            'hostname' => ['nullable', 'string', 'max:160'],
            'status' => ['required', Rule::enum(ServerStatus::class)],
            'capacity' => ['required', 'integer', 'min:1'],
            'current_load' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
