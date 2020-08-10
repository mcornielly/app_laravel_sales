<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Category extends Model
{
    use SoftDeletes, LaravelVueDatatableTrait; //Implementamos 

    protected $dates = ['deleted_at']; //Registramos la nueva columna

    protected $fillable = ['name','url','description','status'];

    public function getRouteKeyName()
    {
        return 'url';
    }  

    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'name' => [
            'searchable' => true,
        ],
        'url' => [
            'searchable' => true,
        ],
        'description' => [
            'searchable' => true,
        ],
        'status' => [
            'searchable' => true,
        ]
    ];


    public static function create(array $attributes = [])
    {
        $category = static::query()->create($attributes);
        $category->generateUrl();

        return $category;
    }  

    public function generateUrl()
    {
    
        $url = Str::slug($this->name, '-');
       
        if($this::whereUrl($url)->exists())
        {
            $url = $url ."-" . $this->id;
        }

        $this->url = $url;

        $this->save();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getStatusAttribute($status)
    {
        if($status == 1){
            return "ACTIVO";
        }else{
            return "INACTIVO";
        }

    }


}
