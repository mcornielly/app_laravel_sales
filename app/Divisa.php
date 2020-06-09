<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;


class Divisa extends Model
{
    use LaravelVueDatatableTrait;

    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'price' => [
            'searchable' => true,
        ],
        'user_id' => [
            'searchable' => true,
        ],
        'created_at' => [
            'searchable' => true,
        ]
    ];

    protected $fillable = ['price','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
