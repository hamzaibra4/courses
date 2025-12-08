<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentCourse extends Model
{
    use HasFactory, UUID;
    
    protected $table = 'payment_course';
}
