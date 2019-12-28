<?php

namespace Tests\Feature\Api;

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

        $response = $this->postJson(route('api.task.add'), ['url' => $task->url]);

        $response
            ->assertStatus(200)
            ->assertJsonPath('data.url', $task->url);
    }

    /**
     * Adding without required param: url
     *
     * @return void
     */
    public function testAddTaskNoUrl()
    {
        $response = $this->postJson(route('api.task.add'));

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['url' => 'The url field is required.']);
    }

    /**
     * Adding with wrong param: url
     *
     * @return void
     */
    public function testAddTaskWrongUrl()
    {
        $response = $this->postJson(route('api.task.add'), ['url' => 'test']);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['url' => 'The url format is invalid.']);
    }

    /**
     * Adding with empty param: url
     *
     * @return void
     */
    public function testAddTaskEmptyUrl()
    {
        $response = $this->postJson(route('api.task.add'), ['url' => '']);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['url' => 'The url field is required.']);
    }
}
