<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use UUID;
    public function getCourse(){
        return $this->belongsTo(Course::class,'course_id','id');
    }
}
