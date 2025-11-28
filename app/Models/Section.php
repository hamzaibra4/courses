<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use UUID;

    public function getSectionVideo()
    {
        return $this->hasMany(SectionVideo::class, 'section_id','id');
    }
    public function getChapter(){
        return $this->belongsTo(Chapter::class,'chapter_id','id');
    }
}
