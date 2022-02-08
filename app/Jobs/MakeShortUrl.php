<?php

namespace App\Jobs;

use App\Services\MyObserver;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Crawler\Crawler;

class MakeShortUrl implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private string $urlRegistered){}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Crawler::create()
            ->setCrawlObserver(new MyObserver())
            ->startCrawling($this->url);
    }
}
