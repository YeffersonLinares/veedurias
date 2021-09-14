<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class TipoDocumento2 extends Model
{	
	use LogsActivity;

    protected $connection = "dinamico";
	protected static $logAttributes = ['*'];

    protected static $logName       = 'tipo documento';

    protected $table = 'tipo_documento';
}
