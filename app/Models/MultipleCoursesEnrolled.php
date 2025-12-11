<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultipleCoursesEnrolled extends Model
{
    use HasFactory, UUID;

    protected $table = 'multiple_courses_enrolled';

    public function getCourse(){
        return $this->belongsTo(Course::class,'course_id','id');
    }

}
