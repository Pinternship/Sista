<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cooperation extends Model
{
    protected $dates = ['mulai_paket', 'akhir_paket'];
    protected $guarded = [];
}
