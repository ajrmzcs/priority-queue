<?php

namespace App\Jobs;

use App\PriorityJobs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class ProcessJobByPriority implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $priorityJob;

    /**
     * Create a new job instance.
     *
     * @param PriorityJobs $priorityJob
     */
    public function __construct(PriorityJobs $priorityJob)
    {
        $this->priorityJob = $priorityJob;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Artisan::call('priority-queue:' . $this->priorityJob->command, [
            'priorityJobId' => $this->priorityJob->id,
            'processorId' => $this->job->getJobId()
        ]);
    }
}
