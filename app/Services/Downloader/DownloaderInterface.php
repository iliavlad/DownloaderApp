<?php

namespace App\Services\Downloader;

interface DownloaderInterface
{
    /**
     * Download url and return content
     *
     * @param url $url
     */
    public function download($url);
}