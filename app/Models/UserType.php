<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class UserType extends Model
{
    use HasFactory, UUID;

    protected $table = 'user_types';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name', 'key'];


}
