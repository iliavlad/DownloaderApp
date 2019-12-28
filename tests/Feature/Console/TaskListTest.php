<?php

namespace Tests\Feature\Console;

use Tests\TestCase;
use App\Task;
use App\Repositories\TaskRepository;

class TaskListTest extends TestCase
{
    /**
     * A list without tasks
     *
     * @return void
     */
    public function testNoTask()
    {
        $collection = new \Illuminate\Database\Eloquent\Collection();

        $this->partialMock(TaskRepository::class, function ($mock) use ($collection) {
            $mock->shouldReceive('all')->once()->andReturn($collection);
        });

        $this->artisan('tasks:show')
            ->expectsOutput('No tasks.')
            ->assertExitCode(0);
    }

    /**
     * A list with tasks
     *
     * @return void
     */
    public function testHasTask()
    {
        $taskCount = 3;

        $collection = factory(Task::class, $taskCount)->make();

        $this->partialMock(TaskRepository::class, function ($mock) use ($collection) {
            $mock->shouldReceive('all')->once()->andReturn($collection);
        });

        $this->artisan('tasks:show')
            ->expectsOutput('List of ' . $taskCount . ' tasks.')
            ->assertExitCode(0);
    }
}
