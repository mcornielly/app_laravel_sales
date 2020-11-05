<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserRolesController extends Controller
{
    public function update(Request $request, User $user)
    {
        $user = User::find($request->id);
        $user->syncRoles($request->role);

        return $user;
    }
}
