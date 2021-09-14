<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veeduria extends Model
{
    use HasFactory;
    protected $connection = "dinamico";
    protected $table = 'veeduria';

    public function soporte()
    {
        return $this->hasMany(VeeduriaSoporte::class, 'id_veeduria','id');
    }

    public function departamento()
    {
        return $this->hasOne(Departamento::class,'id','dep_id');
    }
    public function ciudad()
    {
        return $this->hasOne(Ciudad::class,'id','ciu_id');
    }
    public function veeduriaIntegrante()
    {
        return $this->hasMany(VeeduriaIntegrante::class,'id_veeduria','id');
    }

    public function tipo_veeduria()
    {
        return $this->hasOne(TipoVeeduria::class, 'id', 'tipo_id');
    }
}
