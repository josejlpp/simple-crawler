<?php

namespace App\Services;

use App\Models\UrlShort;
use http\Exception;
use phpDocumentor\Reflection\Types\Collection;
use function PHPUnit\Framework\throwException;

class ShortUrlMaker
{
    /**
     * @throws \Exception
     */
    public function makePath(string $originalUrl): string
    {
        $uniqueShortUrl = false;
        $verifyQtd = 1;

        do{
            $shortUrl = substr(sha1($originalUrl), 0, $verifyQtd);
            if(UrlShort::where('short_url', $shortUrl)->count() == 0) {
                $uniqueShortUrl = true;
            }
            $verifyQtd++;
        }while($uniqueShortUrl === false);

        return $shortUrl;
    }

    public function register(array $data): UrlShort
    {
        $this->urlExists($data['original_url']);
        return UrlShort::create($data);
    }

    private function urlExists(string $url): void
    {
        if(UrlShort::where('original_url', $url)->count() > 0) throw new \Exception('Url already exists!');
    }

    public function registerTitle(string $title, $url): void
    {
        $urlSaved = (new UrlShort())->where('original_url', $url)->first();
        if(strlen(trim($title)) == 0) $title = $urlSaved->original_url;
        $urlSaved->title = $title;
        $urlSaved->save();
    }
}
