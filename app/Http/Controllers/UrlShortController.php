<?php

namespace App\Http\Controllers;

use App\Models\UrlShort;

class UrlShortController extends Controller
{
    public function listMoreAccess()
    {
        $moreAccess = UrlShort::orderByDesc('access_count')->take(100)->get(['title', 'short_url', 'access_count']);
        return view('more-access', compact('moreAccess'));
    }
}
