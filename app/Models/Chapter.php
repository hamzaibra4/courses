<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory, UUID;

    public function getSections()
    {
        return $this->hasMany(Section::class, 'chapter_id','id')->orderBy('item_index');
    }
    public function getCourse(){
        return $this->belongsTo(Course::class,'course_id','id');
    }

    public function getMaterials()
    {
        return $this->hasMany(Material::class,'chapter_id','id')->orderBy('item_index');
    }
}
