<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteVideo extends Model
{
    use HasFactory, UUID;
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function getVideo(){
        return $this->belongsTo(SectionVideo::class,'section_video_id','id');
    }
}
