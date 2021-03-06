<?php

namespace Tests\Feature;

use App\Repository\UrlRepository;
use App\Services\MyObserver;
use App\Services\ShortUrlMaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Crawler\Crawler;
use Tests\TestCase;

class ShortUrlTest extends TestCase
{
    private UrlRepository $urlRepo;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->urlRepo = new UrlRepository();
        parent::__construct($name, $data, $dataName);
    }

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
        $this->urlRepo->register($data);
    }

    public function test_register()
    {
        $url = 'http://localhost';
        $this->registerUrl($url);

        $countRegister = $this->urlRepo->howManyUrlExists($url);
        $this->urlRepo->deleteByUrl($url);
        $this->assertEquals(1, $countRegister);
    }

    /** skop */
    public function test_Api()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );

        $data = [
            'original_url' => 'https://google.com/',
            'short_url' => '5',
            'title' => '',
            'access_count' => 0,
        ];

        $this->urlRepo->register($data);

        $countRegister = $this->urlRepo->howManyUrlExists($data['original_url']);

        Crawler::create()
            ->setCrawlObserver(new MyObserver())
            ->startCrawling($data['original_url']);

        $urlModel = $this->urlRepo->findByOriginalUrl($data['original_url']);
        $this->urlRepo->deleteByUrl($data['original_url']);
        $this->assertEquals('Google', $urlModel->title);
    }
}
