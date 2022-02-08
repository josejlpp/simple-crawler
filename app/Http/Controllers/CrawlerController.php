<?php

namespace App\Http\Controllers;

use App\Jobs\MakeShortUrl;
use App\Models\UrlShort;
use App\Services\MyObserver;
use App\Services\ShortUrlMaker;
use Illuminate\Http\Request;
use Spatie\Crawler\Crawler;

class CrawlerController extends Controller
{
    public function shortUrl(Request $request)
    {
        $url = $request->get('url');
        $shortMaker = new ShortUrlMaker();
        $short_url = $shortMaker->makePath($url);
        $data = [
            'original_url' => $url,
            'short_url' => $short_url,
            'title' => '',
            'access_count' => 0,
        ];

        $shortMaker->register($data);

        $this->dispatch(
            new MakeShortUrl($url)
        );

        return response(json_encode(['new_url' => env('APP_URL') . '/' .$short_url]), 200);
    }
}
