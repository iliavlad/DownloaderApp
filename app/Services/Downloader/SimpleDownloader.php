<?php

namespace App\Services\Downloader;

/**
 * Download file via file_get_contents()
 *   Do not stop and show warning if this is not file
 */
class SimpleDownloader implements DownloaderInterface
{
    /**
     * Bytes to download
     */
    const MAXLENGTHTODOWNLOAD = 1024 * 1024;

    public function download($url)
    {
        $file = @file_get_contents($url, false, null, 0, self::MAXLENGTHTODOWNLOAD);

        return $file;
    }
}
