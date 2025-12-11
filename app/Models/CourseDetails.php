<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class   CourseDetails extends Model
{
    use HasFactory, UUID;
    public function getCourse(){
        return $this->belongsTo(Course::class,'course_id','id');
    }
}
