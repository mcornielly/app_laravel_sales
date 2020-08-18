<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailSale extends Model
{
    protected $fillable = [
    	'sale_id', 'product_id', 'detail_sale','quantity', 'price', 'discount'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    } 

    public function products()
    {    
        return $this->hasMany(Product::class);
    }
}
