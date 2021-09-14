<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoVeeduria extends Model
{
    use HasFactory;

    protected $connection = 'dinamico';
    protected $table = 'tipo_veeduria';
}
