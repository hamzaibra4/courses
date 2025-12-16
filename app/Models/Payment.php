<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory, UUID;

    public function getStudent(){
        return $this->belongsTo(Student::class,'student_id','id');
    }
    public function getCourses(){
        return $this->belongsToMany(Course::class, 'payment_courses', 'payment_id', 'course_id');
    }

    public function getEnrollment()
    {
        return $this->belongsTo(EnrolledCourse::class,'enrolled_course_id','id');
    }
}
