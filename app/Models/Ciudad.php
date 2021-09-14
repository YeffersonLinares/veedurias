<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $connection = 'dinamico';
    protected $table = 'ciudades';
    // protected $fillable = [
    //     'id_departamento',
    //     'nombre',
    //     'condicion',
    //     'codigo_dane'
    // ];
}
