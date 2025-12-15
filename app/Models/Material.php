<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory, UUID;
    public function getChapter(){
        return $this->belongsTo(Chapter::class,'chapter_id','id');
    }
    public function getMaterialPdfs(){
        return $this->hasMany(MaterialPdf::class)->orderBy('order');
    }

    public function getSection(){
        return $this->belongsTo(Section::class,'section_id','id');
    }

}
