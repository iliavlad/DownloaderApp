<?php

namespace App\Http\Controllers;

use App\Task;
use App\Repositories\TaskRepository;
use App\Http\Requests\StoreTaskRequest;
use App\Services\TaskService;

/**
 * Task web controller
 */
class TaskController extends Controller
{
    /**
     * Tasks list
     *
     * @param TaskRepository $repo
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(TaskRepository $repo)
    {
        $tasks = $repo->all();

        return view('task', [
            'tasks' => $tasks,
        ]);
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
        $service->addTask($request->url, Task::WEB);

        return redirect()->route('task.list');
    }
}
