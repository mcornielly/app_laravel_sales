<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
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

        $query = User::orderBy($orderBy, $orderByDir)
                ->paginate($length);
        // $query = User::eloquentQuery($orderBy, $orderByDir, $searchValue);
        $data = $query;
        
        return new DataTableCollectionResource($data);
    }

    public function permissions_user()
    {
        $permissions = [];
        foreach (Permission::all() as $permission) {
          if (Auth::user()->can($permission->name)) {
            $permissions[] = $permission->name;
          }
        }

        return $permissions;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Request $request, $id)
    {
        $user = User::find($id);
        
        if(request()->wantsJson()){

            return $user;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Request $request, $id)
    {
        $user = User::find($id);
        
        if(request()->wantsJson()){
            return $user;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = $request->validate([
            'name' => 'required',
            'email' => 'required|min:6|unique:users,id,' . $id,
        ]);
        
        if($request->filled('password'))
        {
            $rules = $request->validate([
                'password' => 'min:6',
            ]);    
           
        }
        
        $user = User::findOrFail($id);
        $user->update($rules);

        if(request()->wantsJson()){
            return $user;
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
        //
    }
}
