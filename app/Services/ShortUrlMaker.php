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

        if($this->urlExists($originalUrl)) throw new \Exception('Url already exists!');

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
        return UrlShort::create($data);
    }

    private function urlExists(string $url): bool
    {
       return UrlShort::where('original_url', $url)->count() > 0;
    }
}
