<?php

namespace App\Http\Controllers;

use App\Models\UrlShort;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function goToOriginal(Request $request, $pathShort)
    {
        $shortUrl = (new UrlShort())->where('short_url', $pathShort)->first();
        $shortUrl->access_count = $shortUrl->access_count + 1;
        $shortUrl->save();

        return redirect($shortUrl->original_url);
    }
}
