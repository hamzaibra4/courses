<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use UUID;

    public function getSection()
    {
        return $this->hasMany(Section::class, 'chapter_id','id');
    }
    public function getCourse(){
        return $this->belongsTo(Course::class,'course_id','id');
    }
}
