<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Integrante extends Model
{
    use HasFactory;
    protected $table = 'integrante';

    public function tipoIdentificacion()
    {
        return $this->hasOne(TipoIdentificacion::class,'id','id_tipo_identificacion');
    }

}
