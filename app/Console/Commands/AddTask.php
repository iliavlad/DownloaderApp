<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use App\Task;
use App\Services\TaskService;

/**
 * Add tasks artisan command
 */
class AddTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:add {url : The url to download}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add url to download.';

    /**
     * Task service
     *
     * @var TaskService
     */
    private $taskService;

    /**
     * Create a new command instance.
     *
     * @param TaskService
     * @return void
     */
    public function __construct(TaskService $service)
    {
        parent::__construct();

        $this->taskService = $service;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $validator = Validator::make($this->arguments(), [
            'url' => 'required|url',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
        } else {
            $task = $this->taskService->addTask($this->argument('url'), Task::CLI);

            $this->info('Add task with url ' . $task->url);
            $this->info('Call tasks:show to print tasks list.');
        }
    }
}
