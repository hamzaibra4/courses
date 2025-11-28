<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory, UUID;
    public function getPayment(){
        return $this->hasMany(Payment::class);
    }
    public function getChapter()
    {
        return $this->hasMany(Chapter::class, 'course_id','id');
    }
}
