<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Task;

/**
 * Test Task getFileNameFromUrl
 */
class TaskTest extends TestCase
{
    /**
     * Test correct url
     *
     * @return void
     */
    public function testTestPhp()
    {
        $task = factory(Task::class)->make(['url' => 'http://test/test.php']);
        
        $this->assertEquals($task->id . '-test.php', $task->getFileNameFromUrl());
    }

    /**
     * Test empty url
     *
     * @return void
     */
    public function testEmptyUrl()
    {
        $task = factory(Task::class)->make(['url' => '']);

        $this->assertEquals($task->id . '-.html', $task->getFileNameFromUrl());
    }

    /**
     * Test host url
     *
     * @return void
     */
    public function testHostUrl()
    {
        $task = factory(Task::class)->make(['url' => 'http://host']);

        $this->assertEquals($task->id . '-host.html', $task->getFileNameFromUrl());
    }

    /**
     * Test only path url
     *
     * @return void
     */
    public function testOnlyPathUrl()
    {
        $task = factory(Task::class)->make(['url' => 'host']);

        $this->assertEquals($task->id . '-host', $task->getFileNameFromUrl());
    }

    /**
     * Test url with incorrect file name
     *
     * @return void
     */
    public function testIncorrectFileName()
    {
        $task = factory(Task::class)->make(['url' => 'http://host/test\1.jpg']);

        $this->assertEquals($task->id . '-test\1.jpg', $task->getFileNameFromUrl());
    }
}
