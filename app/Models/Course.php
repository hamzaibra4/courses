<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory, UUID;
    public function getPayment(){
        return $this->belongsToMany(Payment::class, 'payment_course', 'course_id', 'payment_id');
    }
    public function getChapters()
    {
        return $this->hasMany(Chapter::class, 'course_id','id');
    }
    public function getInRolledCourses(){
        return $this->belongsToMany(EnrolledCourse::class,'multiple_courses_enrolled','course_id','enrolled_course_id');
    }
    public function getDetails(){
        return $this->hasMany(CourseDetails::class);
    }
}
