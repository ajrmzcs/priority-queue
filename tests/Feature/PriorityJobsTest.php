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
    public function it_lists_paginated_priority_jobs()
    {
        $this->json('GET','api/priorityjobs')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'submitter_id',
                        'processor_id',
                        'priority',
                        'command',
                        'start_date',
                        'end_date',
                        'created_at',
                        'updated_at',
                    ]
                ],
                'links'
            ]);
    }

    /** @test */
    public function it_creates_priority_jobs()
    {
        $this->json('POST','api/priorityjobs', [
            'submitter_id'  => 1,
            'priority'      => 'high',
            'command'       => 'command_1'
            ])
            ->assertStatus(201);

        $this->assertDatabaseHas('priority_jobs', [
            'priority'          => 'high',
        ]);

    }

    /** @test */
    public function it_calculates_average_time()
    {
        $avgProcessingTime = ProcessingTime::getAverageProcessedTime();
        $this->assertEquals(10, $avgProcessingTime->average_request_time);
    }
}
