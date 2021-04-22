<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $guarded = [];

    public function getResumeUrlAttribute(){
        return asset('storage/uploads/resume/'.$this->resume);
    }

    // Dont thing this working
    public function getNewPhotoAttribute(){
        return asset('storage/uploads/apply/newphoto/'.$this->photo);
    }

    // And i just try too use this
    public function getPhotoUrlAttribute(){
        if ($this->photo){
            return asset('storage/uploads/apply/newphoto/'.$this->photo);
        }
        return asset('assets/images/company.png');
    }

    public function job(){
        return $this->belongsTo(Job::class);
    }
}
