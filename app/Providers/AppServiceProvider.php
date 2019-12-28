<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Downloader\DownloaderInterface;
use App\Services\Downloader\SimpleDownloader;

class AppServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        DownloaderInterface::class => SimpleDownloader::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
