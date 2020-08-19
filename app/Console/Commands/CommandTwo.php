<?php

namespace App\Console\Commands;

use App\PriorityJobs;
use Illuminate\Console\Command;

class CommandTwo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'priority-queue:command_1 {priorityJobId} {processorId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Priority Queue second test command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $priorityJob = PriorityJobs::find($this->argument('priorityJobId'));
        $priorityJob->processor_id = $this->argument('processorId');
        $priorityJob->start_date = now();

        sleep(30);

        $priorityJob->end_date = now();
        $priorityJob->save();
    }
}
