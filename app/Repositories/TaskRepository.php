<?php

namespace App\Repositories;

use App\Task;

/**
 * Layer to work with database
 */
class TaskRepository
{
    /**
     * Get all tasks from database
     *
     * @param array $columns Which params of task to select from database
     * @return Collection
     */
    public function all(array $columns = ['*'])
    {
        return Task::all($columns);
    }

    /**
     * Add task to database
     *
     * @param string $url
     * @param string $addedBy
     * @return Task
     */
    public function add(string $url, string $addedBy)
    {
        $task = new Task();

        $task->url = $url;
        $task->status = Task::PENDING;
        $task->local_path = '';
        $task->added_by = $addedBy;

        $task->save();

        return $task;
    }

    /**
     * Sync task with database
     *
     * @param Task $task
     * @return Task
     */
    public function sync(Task $task)
    {
        $task->save();

        return $task;
    }
}
