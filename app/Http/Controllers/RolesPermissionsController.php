<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RolesPermissionsController extends Controller
{
    public function edit(Role $role, Request $request)
    {
        return Role::with('permissions')->find($role);   
    }
}
