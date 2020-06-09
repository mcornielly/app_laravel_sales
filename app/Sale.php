<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['customer_id','user_id','type_voucher','num_voucher','num_bill','tax','total','status'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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

}
