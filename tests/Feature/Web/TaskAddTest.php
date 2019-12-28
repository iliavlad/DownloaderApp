<?php

namespace Tests\Feature\Web;

use Tests\TestCase;
use App\Task;
use App\Services\TaskService;

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

        $response = $this->post(route('task.add'), ['url' => $task->url]);

        $response->assertSessionHasNoErrors();

        $response->assertRedirect(route('task.list'));
    }

    /**
     * Adding without required param: url
     *
     * @return void
     */
    public function testAddTaskNoUrl()
    {
        $response = $this->post(route('task.add'));

        $response->assertSessionHasErrors(['url' => 'The url field is required.']);

        $response->assertRedirect(route('task.list'));
    }

    /**
     * Adding with wrong param: url
     *
     * @return void
     */
    public function testAddTaskWrongUrl()
    {
        $response = $this->post(route('task.add'), ['url' => 'test']);

        $response->assertSessionHasErrors(['url' => 'The url format is invalid.']);

        $response->assertRedirect(route('task.list'));
    }

    /**
     * Adding with empty param: url
     *
     * @return void
     */
    public function testAddTaskEmptyUrl()
    {
        $response = $this->post(route('task.add'), ['url' => '']);

        $response->assertSessionHasErrors(['url' => 'The url field is required.']);

        $response->assertRedirect(route('task.list'));
    }
}
