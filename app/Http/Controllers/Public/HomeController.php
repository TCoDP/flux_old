<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Region;
use App\Models\Review;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('public.home', [
            'seo' => $this->seo('home'),
            'plans' => Plan::active()->get(),
            'regions' => Region::active()->get(),
            'reviews' => Review::approved()->featured()->forLocale(app()->getLocale())->latest()->take(6)->get(),
        ]);
    }
}
