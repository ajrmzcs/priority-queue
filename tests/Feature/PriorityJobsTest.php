<?php

namespace Tests\Feature;

use App\PriorityJobs;
use App\Services\ProcessingTime;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PriorityJobsTest extends TestCase
{
    use RefreshDatabase;

    protected $priorityJobs;

    public function setUp(): void
    {
        parent::setUp();

        $now = New Carbon();
        $this->priorityJobs = [
            [
                'submitter_id'   => 1,
                'processor_id'   => 'pro-id',
                'command'        => 'command_1',
                'start_date'     => $now->toDateTimeString(),
                'end_date'       => $now->addSeconds(10)->toDateTimeString(),
            ],
            [
                'submitter_id'   => 1,
                'processor_id'   => 'pro-id',
                'command'        => 'command_1',
                'start_date'     => $now->toDateTimeString(),
                'end_date'       => $now->addSeconds(10)->toDateTimeString(),
            ],
        ];

        PriorityJobs::insert($this->priorityJobs);
    }

    /** @test */
    public function it_calculates_average_time()
    {
        $avgProcessingTime = ProcessingTime::getAverageProcessedTime();
        $this->assertEquals(10, $avgProcessingTime->average_request_time);
    }
}
