<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Task;
use App\Services\TaskService;
use App\Services\Downloader\DownloaderInterface;

/**
 * Job to download file
 */
class DownloadFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Задание для скачивания
     *
     * @var Task
     */
    private $task;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the task
     *
     * @return Task
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TaskService $service, DownloaderInterface $downloader)
    {
        $service->download($this->task, $downloader);
    }
}
