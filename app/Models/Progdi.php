<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progdi extends Model
{
    protected $guarded = [];

    public function code(){
        return $this->belongsTo(User::class);
    }
}
