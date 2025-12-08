<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultipleCoursesInRolle extends Model
{
    use HasFactory, UUID;

    protected $table = 'multiple_courses_in_rolles';
}
