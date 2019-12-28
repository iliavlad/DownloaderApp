<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\Task as TaskResource;
use App\Repositories\TaskRepository;
use App\Services\TaskService;
use App\Task;

/**
 * Task api controller
 */
class TaskController extends Controller
{
    /**
     * Tasks list
     *
     * @param TaskRepository $repo
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(TaskRepository $repo)
    {
        return TaskResource::collection($repo->all());
    }

    /**
     * Add a task
     *
     * @param StoreTaskRequest $request
     * @param TaskService $service
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function add(StoreTaskRequest $request, TaskService $service)
    {
        $task = $service->addTask($request->url, Task::API);

        return new TaskResource($task);
    }
}
