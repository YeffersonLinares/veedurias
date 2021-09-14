<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VeeduriaIntegrante extends Model
{
    use HasFactory;
    protected $connection = "dinamico";
    protected $table = 'veeduria_integrante';

    public function integrante()
    {
        return $this->hasOne(Integrante::class,'id','id_integrante');
    }

}
