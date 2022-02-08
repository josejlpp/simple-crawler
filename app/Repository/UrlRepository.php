<?php

namespace App\Repository;

use App\Models\UrlShort;

class UrlRepository
{
    protected UrlShort $urlModel;

    public function __construct(){
        $this->urlModel = new UrlShort();
    }

    public function register(array $data): UrlShort
    {
        $this->urlExists($data['original_url']);
        return $this->urlModel->create($data);
    }

    public function updateByUrl(array $data, $url): void
    {
        $urlSaved = $this->urlModel->where('original_url', $url)->first();
        $urlSaved->update($data);
    }

    private function urlExists(string $url): void
    {
        if($this->howManyUrlExists($url) > 0) throw new \Exception('Url already exists!');
    }

    public function howManyUrlExists($url)
    {
        return $this->urlModel->where('original_url', $url)->count();
    }

    public function countByShort($shortUrl)
    {
        return $this->urlModel->where('short_url', $shortUrl)->count();
    }

    public function findByOriginalUrl($url)
    {
        return $this->urlModel->where('original_url', $url)->first();
    }

    public function deleteByShort($shortUrl)
    {
        return $this->urlModel->where('short_url', $shortUrl)->delete();
    }

    public function deleteByUrl($url)
    {
        return $this->urlModel->where('original_url', $url)->delete();
    }
}
