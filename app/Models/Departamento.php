<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $connection = "dinamico";
    protected $table = 'departamentos';
    protected $fillable = [
        'idpais',
        'nombre',
        'condicion'
    ];
}
