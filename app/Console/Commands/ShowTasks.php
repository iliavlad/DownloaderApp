<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\Table;
use App\Repositories\TaskRepository;

/**
 * Show tasks artisan command
 */
class ShowTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:show';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show list of tasks.';

    /**
     * Task repo
     *
     * @var TaskRepository
     */
    private $taskRepo;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TaskRepository $repo)
    {
        parent::__construct();

        $this->taskRepo = $repo;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $headers = ['id', 'url', 'status', 'local_path', 'added_by', 'created_at', 'updated_at'];

        $tasks = $this->taskRepo->all($headers);
        
        if ($tasks->isEmpty()) {
            $this->info('No tasks.');
        } else {
            $this->info('List of ' . $tasks->count() . ' tasks.');

            $this
                ->getTable($headers, $tasks->toArray())
                ->setColumnMaxWidth(1, 20)
                ->setColumnMaxWidth(3, 20)
                ->render();
        }
    }

    /**
     * Get table to render
     *
     * @param array $headers
     * @param array $rows
     * @param string $tableStyle
     * @return Table
     */
    private function getTable($headers, $rows, $tableStyle = 'default')
    {
        $table = new Table($this->output);

        $table->setHeaders((array) $headers)->setRows($rows)->setStyle($tableStyle);

        return $table;
    }
}
