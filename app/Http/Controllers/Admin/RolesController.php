<?php

namespace App\Http\Controllers\Admin;

// use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
use App\Http\Requests\RoleCreateRequest;
// use Illuminate\Support\Collection;
// use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Models\Role;
class RolesController extends Controller
{
    // use HasPermissions;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $length = $request->input('length');
        $orderBy = $request->input('column'); //Index
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search');

        $query = \App\Role::eloquentQuery($orderBy, $orderByDir, $searchValue);
        
        if(request()->wantsJson()){
            $data = $query->paginate($length);
            return new DataTableCollectionResource($data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function validate_data_role(RoleCreateRequest $request)
    {
        // if ($this->expectsJson()) {
        //     response()->json(['error', 422]);
        // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|min:5|unique:roles',
            'display_name' => 'required|unique:roles',
            'description' => 'required|min:10',
        ]);
            
        $role = new Role();
        $role->name = Str::lower($request->name);
        $role->display_name = ucwords($request->display_name);
        $role->description = $request->description;
        $role->guard_name = $request->guard_name;
        $role->save();

        if($request->has('permissions')) {
            $role->givePermissionTo($request->permissions);
         }

        if(request()->wantsJson()){
            return $role;
        }    

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        if(request()->wantsJson()){
            return $role;
        }    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        if(request()->wantsJson()){
            return $role;
        }  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {

        $data = $this->validate($request,[
            'name' => 'required|unique:roles,name,'. $request->id,
            'display_name' => 'required|unique:roles,display_name,'. $request->id,
            'description' => 'required|unique:roles,description,'. $request->id,
        ]);
        
        $role->update($data);

        if(request()->wantsJson()){
            return $role;
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        $role->permissions()->detach(); 
        $role->save();
        $role->delete();

       if(request()->wantsJson())
       {
           return $role;
  
       }
    }
}
