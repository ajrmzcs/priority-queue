<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PriorityJob extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'submitter_id'  => $this->submitter_id,
            'processor_id'  => $this->processor_id,
            'priority'      => $this->priority,
            'command'       => $this->command,
            'start_date'    => $this->start_date,
            'end_date'      => $this->end_date,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
