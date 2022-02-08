<?php

namespace App\Services;

use App\Models\UrlShort;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlObservers\CrawlObserver;

class MyObserver extends CrawlObserver
{

    public function crawled(UriInterface $url, ResponseInterface $response, ?UriInterface $foundOnUrl = null): void
    {
        if($response->getStatusCode() == 200){
            $html = $response->getBody()->__toString();
            $dom  = new \DOMDocument();
            $dom->loadHTML($html, LIBXML_NOERROR);
            $dom->preserveWhiteSpace = false;

            $title = $dom->getElementsByTagName('title')->item(0)->nodeValue;
            $url = (new UrlShort())->where('original_url', $url->__toString())->firstOrFail();
            if(strlen(trim($title)) == 0) $title = $url->original_url;
            $url->title = $title;
            $url->save();
        }
    }

    public function crawlFailed(UriInterface $url, RequestException $requestException, ?UriInterface $foundOnUrl = null): void
    {
        Log::error($requestException->getMessage(), [$url->__toString()]);
    }
}
