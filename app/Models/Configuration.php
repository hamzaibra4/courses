<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use UUID;
    protected $table = 'configurations';
}
