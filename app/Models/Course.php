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
    public function getChapter()
    {
        return $this->hasMany(Chapter::class, 'course_id','id');
    }
    public function getInRolledCourses(){
        return $this->belongsToMany(inRolledCourse::class,'multiple_courses_in_rolles','course_id','in_rolled_course_id');
    }
}
