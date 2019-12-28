<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Task model
 */
class Task extends Model
{
    const PENDING = 'pending';
    const DOWNLOADING = 'downloading';
    const COMPLETE = 'complete';
    const ERROR = 'error';

    /**
     * Possible status
     */
    const POSSIBLESTATUS = [self::PENDING, self::DOWNLOADING, self::COMPLETE, self::ERROR];

    const API = 'api';
    const WEB = 'web';
    const CLI = 'cli';

    /**
     * Possible agents to add a task
     */
    const POSSIBLEADDEDBY = [self::API, self::WEB, self::CLI];

    /**
     * Make a file name from url
     *   Get a part after last '/'. If empty, get a host and add .html.
     *
     * @return string
     */
    public function getFileNameFromUrl()
    {
        $fileName = parse_url($this->url, PHP_URL_PATH);
        $lastDelimiterPos = strrpos($fileName, '/');
        if (false !== $lastDelimiterPos) {
            $fileName = substr($fileName, $lastDelimiterPos + 1);
        }

        if (!$fileName) {
            $host = parse_url($this->url, PHP_URL_HOST);
            $fileName = $host . '.html';
        }

        $fileName = $this->id . '-' . $fileName;

        return $fileName;
    }
}
