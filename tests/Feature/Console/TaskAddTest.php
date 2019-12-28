<?php

namespace Tests\Feature\Console;

use Tests\TestCase;
use App\Task;
use App\Services\TaskService;

/**
 * There are no test to empty url since it checked by AddTask command $signature
 * Checks only to valid url
 */
class TaskAddTest extends TestCase
{
    /**
     * Adding without errors
     *
     * @return void
     */
    public function testAddTask()
    {
        $task = factory(Task::class)->make();

        $this->partialMock(TaskService::class, function ($mock) use ($task) {
            $mock->shouldReceive('addTask')->once()->andReturn($task);
        });

        $this->artisan('tasks:add', ['url' => $task->url])
            ->expectsOutput('Add task with url ' . $task->url)
            ->assertExitCode(0);
    }

    /**
     * Adding with wrong param: url
     *
     * @return void
     */
    public function testAddTaskWrongUrl()
    {
        $this->artisan('tasks:add', ['url' => 'test'])
            ->expectsOutput('The url format is invalid.')
            ->assertExitCode(0);
    }
}
