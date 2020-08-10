<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Income extends Model
{
    use LaravelVueDatatableTrait;

    protected $fillable = ['provider_id','user_id','type_voucher','num_voucher','num_bill','tax','total','status'];


    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
        ],
        'provider_id' => [
            'searchable' => true,
        ],
        'customer_name' => [
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
            'user' => [
                "model" => \App\User::class,
                'foreign_key' => 'user_id',
                'columns' => [
                    'name' => [
                        'searchable' => true,
                        'orderable' => true,
                    ],
                ],
            ],
            'provider' => [
                "model" => \App\User::class,
                'foreign_key' => 'provider_id',
                'columns' => [
                    'name' => [
                        'searchable' => true,
                        'orderable' => true,
                    ],
                ],
            ],
        ],
        "hasMany" => [
            "deatil_incomes" => [
                "model" => \App\DetailIncome::class,
                'foreign_key' => 'income_id',
                'columns' => [
                    'income_id' => [
                        'searchable' => true,
                        'orderable' => true,
                    ],
                ],    
            ],
        ],    
    ];
    
    public function provider()
    {    
        return $this->belongsTo(Provider::class);
    }

    public function customer()
    {    
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {    
        return $this->belongsTo(User::class);
    }

    public function detail_incomes()
    {    
        return $this->hasMany(DetailIncome::class);
    }

    public function scopebyYearAndMonthIncomes($query)
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
