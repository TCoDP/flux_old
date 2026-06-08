<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ReviewStatus;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{
    public function index(): View
    {
        return view('admin.reviews.index', [
            'reviews' => Review::with('user')->latest()->paginate(15),
            'statuses' => ReviewStatus::cases(),
        ]);
    }

    public function edit(Review $review): View
    {
        return view('admin.reviews.edit', ['review' => $review, 'statuses' => ReviewStatus::cases()]);
    }

    public function update(Request $request, Review $review): RedirectResponse
    {
        $data = $request->validate([
            'author_name' => ['required', 'string', 'max:120'],
            'author_role' => ['nullable', 'string', 'max:120'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'body' => ['required', 'string'],
            'locale' => ['required', 'in:ru,en'],
            'status' => ['required', Rule::enum(ReviewStatus::class)],
            'is_featured' => ['boolean'],
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $review->update($data);

        return redirect()->route('admin.reviews.index')->with('status', __('admin.saved'));
    }

    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();

        return back()->with('status', __('admin.deleted'));
    }
}
