<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Provider extends Model
{
    use LaravelVueDatatableTrait;
    
    protected $fillable = ['customer_id','name','url','contact_phone'];
    
    public function getRouteKeyName()
    {
        return 'url';
    }

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
    
    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
        ],
        'customer_id' => [
            'searchable' => true,
        ],
        'name' => [
            'searchable' => true,
        ],
        'contact_phone' => [
            'searchable' => true,
        ],

    ];

    protected $dataTableRelationships = [
        "belongsTo" => [
            'customer' => [
                "model" => \App\Customer::class,
                'foreign_key' => 'customer_id',
                'columns' => [
                    'name' => [
                        'searchable' => true,
                        'orderable' => true,
                    ],
                    'num_document' => [
                        'searchable' => true,
                        'orderable' => true,
                    ],
                    'num_phone' => [
                        'searchable' => true,
                        'orderable' => true,
                    ],
                    'email' => [
                        'searchable' => true,
                        'orderable' => true,
                    ],
                ],
            ],
        ],
    ];
  
  
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
