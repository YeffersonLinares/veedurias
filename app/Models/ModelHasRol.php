<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHasRol extends Model
{
    use HasFactory;
    protected $table      = 'model_has_roles';
    public $timestamps    = false;
    protected $connection = "dinamico";
}
