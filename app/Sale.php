<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Sale extends Model
{
    use LaravelVueDatatableTrait; //Implementamos 

    protected $fillable = ['customer_id','user_id','type_voucher','num_voucher','num_bill','tax','total','status'];


    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'customer_id' => [
            'searchable' => true,
        ],
        'user_id' => [
            'searchable' => true,
        ],
        'type_voucher' => [
            'searchable' => true,
        ],
        'num_voucher' => [
            'searchable' => true,
        ],
        'num_bill' => [
            'searchable' => true,
        ],
        'tax' => [
            'searchable' => true,
        ],
        'total' => [
            'searchable' => true,
        ],
        'status' => [
            'searchable' => true,
        ],
        'created_at' => [
            'searchable' => true,
        ]
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
                ],
            ],
            'user' => [
                "model" => \App\User::class,
                'foreign_key' => 'user_id',
                'columns' => [
                    'name' => [
                        'searchable' => true,
                        'orderable' => true,
                    ],
                ],
            ]

        ]
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function scopebyYearAndMonthSales($query)
    {
        return $query->selectRaw('year(created_at) year')
                ->selectRaw('month(created_at) month')
                ->selectRaw('monthname(created_at) monthname')
                ->selectRaw('sum(total) sum')
                ->selectRaw('count(*) sales')
                ->groupBy('year','month','monthname');
    }

    public function getStatusAttribute($status)
    {
        if($status == 1){
            return "REGISTRADO";
        }else{
            return "ANULADO";
        }

    }

}
