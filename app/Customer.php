<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Customer extends Model
{
    use LaravelVueDatatableTrait; //Implementamos 

    protected $fillable = ['name','type_document','num_document','address','num_phone','email','user_id'];

    public function getRouteKeyName()
    {
        return 'url';
    }
    
    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
        ],
        'name' => [
            'searchable' => true,
        ],
        'type_document' => [
            'searchable' => true,
        ],
        'num_document' => [
            'searchable' => true,
        ],
        'address' => [
            'searchable' => true,
        ],
        'num_phone' => [
            'searchable' => true,
        ],
        'email' => [
            'searchable' => true,
        ],

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

    public function provider()
    {
        return $this->hasOne(Provider::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
