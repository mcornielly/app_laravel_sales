<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Menu extends Model
{
    protected $fillable = ['name','order','hierarchy'];


    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

}
