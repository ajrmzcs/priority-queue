<?php


namespace App\Services;


use App\PriorityJobs;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProcessingTime
{
    /**
     * Get average time in seconds of processed jobs
     *
     * @return \stdClass
     */
    public static function getAverageProcessedTime(): \stdClass
    {
        $priorityJobsAvg = DB::select('SELECT SUM(TIMESTAMPDIFF(SECOND, start_date, end_date)) AS total_request_time, count(*) AS count, '
            . 'ROUND(AVG(TIMESTAMPDIFF(SECOND, start_date, end_date)), 2) AS average_request_time FROM priority_jobs '
            . 'WHERE processor_id IS NOT NULL');


        return current($priorityJobsAvg);

    }


}
