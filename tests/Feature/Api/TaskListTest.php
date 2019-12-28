<?php

namespace Tests\Feature\Api;

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

        $response = $this->getJson(route('api.task.list'));

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'data' => [],
            ]);
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

        $response = $this->getJson(route('api.task.list'));

        $response->assertStatus(200);

        $actual = collect($response->decodeResponseJson('data'));

        $this->assertEquals($taskCount, $actual->count());
    }
}
