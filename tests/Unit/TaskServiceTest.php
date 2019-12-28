<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use App\Task;
use App\Services\TaskService;
use App\Repositories\TaskRepository;
use App\Jobs\DownloadFile;
use App\Services\Downloader\SimpleDownloader;

/**
 * Test TaskService
 */
class TaskServiceTest extends TestCase
{
    /**
     * A test to add Task
     *   There repo adding task and dispatching job should be called
     *
     * @return void
     */
    public function testAddTask()
    {
        $task = factory(Task::class)->make();

        $repo = $this->partialMock(TaskRepository::class, function ($mock) use ($task) {
            $mock->shouldReceive('add')->once()->andReturn($task);
        });

        Bus::fake();

        $service = new TaskService($repo);
        $actual = $service->addTask($task->url, $task->added_by);

        $this->assertEquals($task, $actual);

        Bus::assertDispatched(DownloadFile::class, function ($job) use ($task) {
            return $job->getTask()->id === $task->id;
        });
    }

    /**
     * A test with complete download
     */
    public function testDownloadComplete()
    {
        $task = factory(Task::class)->make();

        $repo = $this->partialMock(TaskRepository::class, function ($mock) use ($task) {
            $mock->shouldReceive('sync')->twice()->andReturn($task);
        });

        $downloader = $this->partialMock(SimpleDownloader::class, function ($mock) {
            $mock->shouldReceive('download')->once()->andReturn('test');
        });

        Storage::fake('public');

        $service = new TaskService($repo);
        $actual = $service->download($task, $downloader);

        $this->assertEquals(Task::COMPLETE, $actual);

        Storage::disk('public')->assertExists($task->getFileNameFromUrl());
    }

    /**
     * A test with download error
     */
    public function testDownloadError()
    {
        $task = factory(Task::class)->make();

        $repo = $this->partialMock(TaskRepository::class, function ($mock) use ($task) {
            $mock->shouldReceive('sync')->twice()->andReturn($task);
        });

        $downloader = $this->partialMock(SimpleDownloader::class, function ($mock) {
            $mock->shouldReceive('download')->once()->andReturn(false);
        });

        Storage::fake('public');

        $service = new TaskService($repo);
        $actual = $service->download($task, $downloader);

        $this->assertEquals(Task::ERROR, $actual);

        Storage::disk('public')->assertMissing($task->getFileNameFromUrl());
    }

    /**
     * A test with download error
     */
    public function testDownloadError1()
    {
        $fileName = '1-test""1.jpg';

        $task = $this->partialMock(Task::class, function ($mock) use ($fileName) {
            $mock->shouldReceive('getFileNameFromUrl')->once()->andReturn($fileName);
        });

        $repo = $this->partialMock(TaskRepository::class, function ($mock) use ($task) {
            $mock->shouldReceive('sync')->twice()->andReturn($task);
        });

        $downloader = $this->partialMock(SimpleDownloader::class, function ($mock) {
            $mock->shouldReceive('download')->once()->andReturn('test');
        });

        Storage::fake('public');

        $service = new TaskService($repo);
        $actual = $service->download($task, $downloader);

        $this->assertEquals(Task::ERROR, $actual);

        Storage::disk('public')->assertMissing($fileName);
    }
}
