<?php

namespace Tests\Feature\Web;

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

        $response = $this->get(route('task.list'));

        $response->assertSee('<p id="notasks">No tasks</p>');
    }

    /**
     * A list with tasks
     *
     * @return void
     */
    public function testHasTask()
    {
        $collection = factory(Task::class, 3)->make();

        $this->partialMock(TaskRepository::class, function ($mock) use ($collection) {
            $mock->shouldReceive('all')->once()->andReturn($collection);
        });

        $response = $this->get(route('task.list'));

        $response->assertSee('<table id="tasklist">');
    }
}
