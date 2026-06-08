<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Contracts\View\View;

class PricingController extends Controller
{
    public function index(): View
    {
        return view('public.pricing', [
            'seo' => $this->seo('pricing'),
            'plans' => Plan::active()->get(),
        ]);
    }
}
