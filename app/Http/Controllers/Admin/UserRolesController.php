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
            
        return $rules;
        
        $user = User::find($request->id);
        $user->roles()->detach();
        $user->syncRoles($rules);
            
        if(request()->wantsJson()){
            return $user;
        }
    }
}
