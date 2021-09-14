<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RutasVue extends Model
{
    use HasFactory;
    protected $table      = 'rutas_vue';
    protected $connection = "centralizado";
}
