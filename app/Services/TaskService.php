<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Task;
use App\Repositories\TaskRepository;
use App\Jobs\DownloadFile;
use App\Services\Downloader\DownloaderInterface;

/**
 * Simple service to download file and update Task status
 *   Uses file_get_contents() to download file
 */
class TaskService
{
    /**
     * Update task in database
     *
     * @var \App\Repositories\TaskRepository
     */
    private $taskRepo;

    /**
     * Constructor
     *
     * @param \App\Repositories\TaskRepository $repo Repo to work with database
     */
    public function __construct(TaskRepository $repo)
    {
        $this->taskRepo = $repo;
    }

    /**
     * Add a task
     *
     * @param string $url
     * @param string $addedBy
     */
    public function addTask(string $url, string $addedBy)
    {
        $task = $this->taskRepo->add($url, $addedBy);

        DownloadFile::dispatch($task);

        return $task;
    }

    /**
     * Process download
     *
     * @param \App\Task $task
     * @return string status
     */
    public function download(Task $task, DownloaderInterface $downloader)
    {
        $task->status = Task::DOWNLOADING;
        $this->taskRepo->sync($task);

        $file = $downloader->download(urlencode($task->url));

        if (false === $file) {
            $task->status = Task::ERROR;
        } else {
            $this->storeFileContent($task, $file);
        }

        $this->taskRepo->sync($task);

        return $task->status;
    }

    /**
     * Store downloaded file content
     *
     * @param Task $task
     * @param string $fileContents
     */
    private function storeFileContent(Task $task, string $fileContents)
    {
        $fileName = $task->getFileNameFromUrl();

        try {
            $putFileStatus = Storage::disk('public')->put($fileName, $fileContents);
            if (false === $putFileStatus) {
                $task->status = Task::ERROR;
            } else {
                $task->status = Task::COMPLETE;
                $task->local_path = Storage::url($fileName);
            }
        } catch (\ErrorException $e) {
            $task->status = Task::ERROR;
        }
    }
}
