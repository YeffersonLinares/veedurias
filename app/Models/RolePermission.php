<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $connection = 'dinamico';

    protected $table = 'role_has_permissions';
}
