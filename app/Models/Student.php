<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory, UUID;
    public function getStudentStatus(){
        return $this->belongsTo(StudentType::class,'student_type_id','id');
    }

    public function getCustomers(){
        return $this->hasMany(CustomField::class);
    }
    public function getUser()
    {
        return $this->belongsTo(User::class);
    }
    public function getFullNameAttribute()
    {
        return $this->f_name . ' ' . $this->l_name;
    }
    public function getPayment(){
        return $this->hasMany(Payment::class);
    }
}
