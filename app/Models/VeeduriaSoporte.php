<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VeeduriaSoporte extends Model
{
    use HasFactory;
    protected $connection = "dinamico";
    protected $table = 'veeduria_soporte';

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'id_documento', 'id');
    }
}
