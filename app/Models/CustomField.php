<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    use HasFactory, UUID;
    public function getStudent(){
        return $this->belongsTo(Student::class,'student_id','id');
    }
}
