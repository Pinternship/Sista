<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobFinalReport extends Model
{
    protected $guarded = [];

    public function job(){
        return $this->belongsTo(Job::class);
    }
}
