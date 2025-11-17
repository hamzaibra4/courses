<?php

namespace App\Models;

class DTO
{
    public $data = [];

    public function __construct($array = [])
    {
        $this->data = $array;
    }
}
