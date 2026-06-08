<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RegionController extends Controller
{
    public function index(): View
    {
        return view('admin.regions.index', ['regions' => Region::withCount('servers')->orderBy('sort_order')->get()]);
    }

    public function create(): View
    {
        return view('admin.regions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Region::create($this->validated($request));

        return redirect()->route('admin.regions.index')->with('status', __('admin.saved'));
    }

    public function edit(Region $region): View
    {
        return view('admin.regions.edit', ['region' => $region]);
    }

    public function update(Request $request, Region $region): RedirectResponse
    {
        $region->update($this->validated($request, $region));

        return redirect()->route('admin.regions.index')->with('status', __('admin.saved'));
    }

    public function destroy(Region $region): RedirectResponse
    {
        $region->delete();

        return back()->with('status', __('admin.deleted'));
    }

    private function validated(Request $request, ?Region $region = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'string', Rule::unique('regions', 'slug')->ignore($region?->id)],
            'country_code' => ['nullable', 'string', 'size:2'],
            'city' => ['nullable', 'string', 'max:120'],
            'flag' => ['nullable', 'string', 'max:16'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'load_percent' => ['nullable', 'integer', 'min:0', 'max:100'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
