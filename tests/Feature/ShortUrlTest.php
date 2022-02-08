<?php

namespace Tests\Feature;

use App\Models\UrlShort;
use App\Services\ShortUrlMaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShortUrlTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_MakeUniqShortUrl()
    {
        $newShortUrl = (new ShortUrlMaker())->makePath('http://localhost/');
        $this->assertEquals('f', $newShortUrl);
    }

    public function test_DontRegisterDuplicateUrl()
    {
        $this->expectExceptionMessage('Url already exists!');
        $url = 'https://www.microsoft.com/';

        $this->registerUrl($url);
        $this->registerUrl($url);
    }

    private function registerUrl($url)
    {
        $shortMaker = new ShortUrlMaker();
        $newShortUrl = $shortMaker->makePath($url);
        $data = [
            'original_url' => $url,
            'short_url' => $newShortUrl,
            'title' => '',
            'access_count' => 0,
        ];
        $shortMaker->register($data);
    }

    public function test_register()
    {
        (new UrlShort())->where('original_url', 'http://localhost')->delete();

        $data = [
            'original_url' => 'http://localhost',
            'short_url' => 'LL',
            'title' => '',
            'access_count' => 0,
        ];
        $shortMaker = new ShortUrlMaker();

        $shortMaker->register($data);

        $countRegister = (new UrlShort())->where('original_url',  $data['original_url'])->count();

        $this->assertEquals(1, $countRegister);
    }
}
