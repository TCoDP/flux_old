<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class LegalController extends Controller
{
    public function privacy(): View
    {
        return view('public.legal.privacy', [
            'seo' => $this->seo('privacy'),
        ]);
    }

    public function terms(): View
    {
        return view('public.legal.terms', [
            'seo' => $this->seo('terms'),
        ]);
    }
}
