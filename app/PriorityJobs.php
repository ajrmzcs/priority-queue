<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriorityJobs extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'submitter_id',
        'processor_id',
        'priority',
    ];
}
