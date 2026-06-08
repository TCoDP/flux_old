<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Contracts\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        return view('public.about', [
            'seo' => $this->seo('about'),
            'regions' => Region::active()->get(),
        ]);
    }
}
