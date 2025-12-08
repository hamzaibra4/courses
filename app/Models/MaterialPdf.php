<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialPdf extends Model
{
    use HasFactory, UUID;
    public function getMaterial(){
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }
    protected $table = 'material_pdfs';
}
