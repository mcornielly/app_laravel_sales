<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RolesPermissionsController extends Controller
{
    public function edit(Role $role, Request $request)
    {

        $rolePermissions = Role::with('permissions')->find($role);
        // $rolePermissions = Role::with('permissions')->find($role)->where('permissions.option','menu');
        // $modulos = Role::find($role->id)->modules()->get(["id","name","option"]);
        
        foreach($rolePermissions as $permissions)
        {
            $allPermissions = $permissions->permissions;    
        }



        return $allPermissions;
        
    }
}
