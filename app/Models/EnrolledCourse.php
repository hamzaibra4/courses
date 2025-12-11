<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrolledCourse extends Model
{
    use HasFactory, UUID;

    public function getStudent(){
        return $this->belongsTo(Student::class,'student_id','id');
    }
    public function getStatus(){
        return $this->belongsTo(RelatedCoursesStatus::class,'status_id','id');
    }
    public function getCourses(){
        return $this->belongsToMany(Course::class,'multiple_courses_enrolled','enrolled_course_id','course_id');
    }
}
