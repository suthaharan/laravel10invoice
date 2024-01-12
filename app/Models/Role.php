<?php

namespace App\Models;

use Spatie\Permission\Models\Role as OriginalRole;

class Role extends OriginalRole
{

    CONST ADMIN = 'admin';
    const SUPERADMIN = 'superadmin';
    const MANAGER = "manager";

    protected $fillable = [
        'name',
        'guard_name',
        'updated_at',
        'created_at',
    ];
}
