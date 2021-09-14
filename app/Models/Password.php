<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Password extends Model
{
    use HasFactory;
    use LogsActivity;
    
    protected static $logName       = 'Password';
    protected $table = "password_log";
    protected $connection = "centralizado";
}
