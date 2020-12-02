<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserRolesController extends Controller
{
    public function update(Request $request, User $user)
    {
        // return $request->all();
        $rules = $request->validate([
            'name' => 'required',
            ]);
            
        
        $role = User::find($request->id);
        $role->syncRoles($rules);
            
        if(request()->wantsJson()){
            return $role;
        }
    }
}
