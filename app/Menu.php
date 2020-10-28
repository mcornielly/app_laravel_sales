<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Menu extends Model
{
    protected $fillable = ['name','order','hierarchy'];


    // public function permissions()
    // {
    //     return $this->hasMany(Permission::class);
    // }

    public function permissions(){
        return $this->hasMany(Permission::class, 'menu_id', 'id')->where('permissions.option',"menu");
    //     return $this->belongsToMany('Spatie\Permission\Models\Permission', 'role_has_permissions', 'role_id', 'permission_id')->where('permissions.option',"menu");
    }

}
