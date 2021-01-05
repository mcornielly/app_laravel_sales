<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Request $request)
    {
        $this->authorize('view', $user);

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
    public function create(Request $request)
    {
        //
    }

    public function validate_data_user(UserCreateRequest $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', new User);
        $role = [
            'name' => $request->role
        ];

        //Creamos el usuario como cliente
        $customer = Customer::create($request->all()); 

        //Creamos el usuario
        $user_new = new User();
        $user_new->id = $customer->id;
        $user_new->name = $request->name;
        $user_new->email = $request->email;
        $user_new->password = $request->password;
        $user_new->save();
        
        //Se llama el Usuario creado, para asignar el rol.
        $user = User::find($customer->id); 
                
        //Asignamos los roles
        if($request->filled('role')){
            $user->assignRole($request->role);
        }
        
        //Asignamos los permisos
        if($request->filled('permissions')){
            $user->givePermissionTo($request->permissions);
        }

        if(request()->wantsJson())
        {
            return $user;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Request $request, $id)
    {
        $this->authorize('view', $user);

        $user = User::find($id);
        $rol_id = $user->roles[0]->id;
        $rol = Role::find($rol_id);
        $permissions_rol = [];
        $permissions_user = [];

        foreach($user->permissions as $permissions){
            if($rol->hasPermissionTo($permissions)){
                $permissions_rol[] = $permissions->name;         
            }else{
                $permissions_user[] = $permissions;
            }
        };
        
        if(request()->wantsJson())
        {
                return [
                    'user' => $user,
                    'permissions_rol' => $permissions_rol,
                    'permissions_user' => $permissions_user,
                ];
            
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
        $this->authorize('update', $user); 

        $user = User::find($id);
        
        if(request()->wantsJson())
        {
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
    public function update(User $user, Request $request, $id)
    {
        $this->authorize('update', $user);

        $rules = $request->validate([
            'name' => 'required|min:3',
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

    public function validate_pass(Request $request){
        $this->validate($request, [
            'password' => 'required|min:8'
        ]);
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

    public function img_profile(Request $request, $id)
    {
        $this->validate($request, [
            'img' => 'required|image'
            ]);
            
        $file = $request->file('img');
        $extension = $file->getClientOriginalExtension();
        $filaName = explode(' ', $request->name);
        $filaName= Str::lower($filaName[0]);
        $fileName = $filaName . '_' . $id . '.' . $extension;

        // return $request->img;
        
        if($request->hasFile('img'))
        {
            $path_img = $request->img->store('public');
            $imageUrl = Storage::url($path_img);
        }
        
        // $avatar = $request->file('img')->store('avatars','public');
        // dd($imageUrl);
        // Image::make($file)->fit(200, 200)->save($imageUrl);
        // $avatar = Storage::putFile($imageUrl);
        // dd($avatar);
        // $photos = $request->file('photo')->store('product','public');
        // $avatar = Storage::putFile('public/images/avatars', $file);
        // $avatar = Storage::url($file);
        // $avatar = Storage::putFile('public/images/avatar/', base64_decode($file_data));
   
        $userAvatarUpdate = User::find($id);
        $userAvatarUpdate->avatar = $imageUrl;
        $userAvatarUpdate->update();
    
        return response()->json([
                'userAvatarUpdate' => $userAvatarUpdate,
                // 'status' => 'Muy bien!',
                // 'msg' => 'Tu foto de perfil se actualizo.',
            ], 200);
    
    }
}
