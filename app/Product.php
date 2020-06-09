<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Product extends Model
{
    use SoftDeletes, LaravelVueDatatableTrait; //Implementamos  

    protected $dates = ['deleted_at']; //Registramos la nueva columna

    protected $fillable = ['name','url','category_id','code','cost_price','description','stock','margin_gain_u',
                           'divisa_unit','wholesale_quantity','margin_gain_w','wholesale_divisa','status'];
    
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
        'category_id' => [
            'searchable' => true,
        ],
        'description' => [
            'searchable' => true,
        ],
        'status' => [
            'searchable' => true,
        ]
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getStatusAttribute($status)
    {
        if($status == 1){
            return "ACTIVO";
        }else{
            return "INACTIVO";
        }

    }

    public static function create(array $attributes = [])
    {
        // $attributes['user_id'] = auth()->id();
        $product = static::query()->create($attributes);
        $product->generateUrl();
        return $product;
    }

    public function generateUrl()
    {
        $url = str_slug($this->name);

        if($this::whereUrl($url)->exists())
        {
            $url = $url ."-" . $this->id;
        }

        $this->url = $url;

        $this->save();
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
