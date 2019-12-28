<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\Downloader\SimpleDownloader;

/**
 * Test SimpleDownloader
 */
class SimpleDownloaderTest extends TestCase
{
    /**
     * A test with correct file
     *
     * @return void
     */
    public function testFileExists()
    {
        $downloader = new SimpleDownloader();
        $file = $downloader->download('./phpunit.xml');

        $this->assertNotFalse($file);
    }

    /**
     * A test with incorrect file
     *
     * @return void
     */
    public function testFileNotExists()
    {
        $downloader = new SimpleDownloader();
        $file = $downloader->download('./phpunit_not_exists.xml');

        $this->assertFalse($file);
    }
}
