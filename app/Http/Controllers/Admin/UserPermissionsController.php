<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
// Response

class UserPermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request->all();
        $user = User::find($request->id);
        // $rol_id = $user->roles[0]->id;
        // $rol = Role::find($rol_id);
        // $permissions_rol = $user->getPermissionsViaRoles()->pluck('name')->toArray();
        // $permissions_request = $request->permissions;
        // $num_permissions_rol = count($permissions_rol);    
        // $num_permissions_request = count($request->permissions);

        if($request->filled('permissions'))
        {
            $user->syncPermissions($request->permissions);
        }

        // var_dump($num_permissions_rol);
        // var_dump($num_permissions_request);
        // $result_permissions = array_diff($permissions_request,$permissions_rol);

        // if($result_permissions){
            
        // }else{
        //     foreach($result_permissions as $permissions){
        //         if($rol->hasPermissionTo($permissions)){
        //             $rol_permissions[] = $permissions;
        //             $rol->syncPermissions($rol_permissions);
        //         }else{
        //             $user_permissions[] = $permissions;
        //             $user->syncPermissions($user_permissions);
        //         }
        //     }
        // };



        // return $request->permissions;
        // return $rol->hasAllDirectPermissions('create category','create divisa');
        // return $request->permissions;
        // if($num_permissions_request > $num_permissions_rol){
        //     dd('1');

        //     // $result_permissions = array_diff($permissions_request,$permissions_rol);
        //     // if(count($result_permissions)){
        //     //     foreach($result_permissions as $permissions){
        //     //         if($rol->hasPermissionTo($permissions)){
        //     //             $rol_permissions[] = $permissions;
        //     //             $rol->syncPermissions($rol_permissions);
        //     //         }else{
        //     //             $user_permissions[] = $permissions;
        //     //             $user->syncPermissions($user_permissions);
        //     //         }
        //     //     }
        //     // }

        // }else{
        //     if(count($request->permissions)){
        //         // $result_permissions = array_diff($permissions_request,$permissions_rol);
        //         // if(count($request->permissions)){
        //             foreach($request->permissions as $permissions){
        //                 if($rol->hasPermissionTo($permissions)){
        //                     $rol_permissions[] = $permissions;
        //                     var_dump($rol_permissions);
        //                     $rol->syncPermissions($rol_permissions);
        //                 }else{
        //                     $user_permissions[] = $permissions;
        //                     $user->syncPermissions($user_permissions);
        //                 }
        //             }
        //         // }
        //     }
        // }

        // return $request->permissions;
        
        // if(count($result_permissions)){
        //     foreach($result_permissions as $permissions){
        //         if($rol->hasPermissionTo($permissions)){
        //             $rol_permissions[] = $permissions;
        //         }else{
        //             $user_permissions[] = $permissions;
        //             $user->syncPermissions($user_permissions);
        //         }
        //     }
        // }

        // // return $permissions_user;
        // // return $permissions_rol . '-' . $permissions_user;
        // if($num_permissions_rol <> $num_permissions_user) {
        //     foreach($request->permissions as $permissions){
        //         // $user->permissions()->detach();
        //         if($rol->hasPermissionTo($permissions)){

        //            return var_dump($permissions);
        //             // array_push($permissionsRol, $permissions);
        //         }else{
        //             // array_push($permissionsUser, $permissions);
        //             // var_dump($permissions);
        //         }

        //     }
        //     $xx = count($permissions);
        //     return $xx;
        // }   

        // return $permissions_user;
        // $rol->permissions()->detach();

        // if($request->filled('permissions'))
        // {
        //     $rol->syncPermissions($request->permissions);
        // }
    }
}
