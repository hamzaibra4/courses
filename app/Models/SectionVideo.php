<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class SectionVideo extends Model
{
  use UUID;
    public function getSection(){
        return $this->belongsTo(Section::class,'section_id','id');
    }
}
