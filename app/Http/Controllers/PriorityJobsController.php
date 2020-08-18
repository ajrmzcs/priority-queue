<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriorityJobRequest;
use App\Http\Resources\PriorityJobCollection;
use App\Http\Resources\PriorityJob as PriorityJobResource;
use App\Jobs\ProcessJobByPriority;
use App\PriorityJobs;
use App\Services\ProcessingTime;

class PriorityJobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return PriorityJobCollection
     */
    public function index()
    {
        return new PriorityJobCollection(PriorityJobs::paginate(50));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PriorityJobRequest $request
     * @return PriorityJobResource
     */
    public function store(PriorityJobRequest $request)
    {
        $priorityJob = PriorityJobs::create($request->all());
        ProcessJobByPriority::dispatch($priorityJob);
        return new PriorityJobResource($priorityJob);
    }

    /**
     * Display the specified resource.
     *
     * @param PriorityJobs $priorityJob
     * @return PriorityJobResource
     */
    public function show(PriorityJobs $priorityJob)
    {
        return new PriorityJobResource($priorityJob);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PriorityJobRequest $request
     * @param  PriorityJobs  $priorityJob
     * @return PriorityJobResource
     */
    public function update(PriorityJobRequest $request, PriorityJobs $priorityJob)
    {
        $priorityJob->submitter_id = $request->submitter_id;
        $priorityJob->priority = $request->priority;
        $priorityJob->command = $request->command;
        $priorityJob->save();

        return new PriorityJobResource($priorityJob);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PriorityJobs $priorityJobs
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(PriorityJobs $priorityJobs)
    {
        $priorityJobs->delete();
        return response()->json([], 204);
    }


    public function getAverageProcessingTime()
    {
        $avgProcessingTime = ProcessingTime::getAverageProcessedTime();
        return response()->json([
            'data' => [
                'processed_requests' => $avgProcessingTime->count,
                'total_request_time_seconds' => $avgProcessingTime->total_request_time,
                'average_request_time_seconds' => $avgProcessingTime->average_request_time,
            ]
        ], 200);
    }

}
