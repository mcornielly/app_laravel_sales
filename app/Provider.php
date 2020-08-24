<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Provider extends Model
{
    use LaravelVueDatatableTrait;
    
    protected $fillable = ['id','name','contact_phone'];
    
    protected $dataTableColumns = [
        'id' => [
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
                'foreign_key' => 'id',
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

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }

    // public function getNameAttribute($value)
    // {
    //     return strtoupper($value);
    // }
}
