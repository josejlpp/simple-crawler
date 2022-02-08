<?php

namespace App\Services;

use App\Repository\UrlRepository;

class ShortUrlMaker
{
    public function makePath(string $originalUrl): string
    {
        $uniqueShortUrl = false;
        $verifyQtd = 1;

        do{
            $shortUrl = substr(sha1($originalUrl), 0, $verifyQtd);
            if((new UrlRepository())->countByShort($shortUrl) == 0) {
                $uniqueShortUrl = true;
            }
            $verifyQtd++;
        }while($uniqueShortUrl === false);

        return $shortUrl;
    }
}
