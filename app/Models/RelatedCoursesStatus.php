<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelatedCoursesStatus extends Model
{
    use HasFactory, UUID;
    public function getInRolledCourses(){
        return $this->hasMany(RelatedCoursesStatus::class,'status_id','id');
    }
}
