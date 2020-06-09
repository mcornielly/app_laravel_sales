<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = ['provider_id','user_id','type_vaucher','num_vaucher','num_bill','tax','total','status'];
    
    public function provider()
    {    
        return $this->belongsTo(Provider::class);
    }

    public function user()
    {    
        return $this->belongsTo(User::class);
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
}
