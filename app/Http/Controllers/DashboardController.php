<?php

namespace App\Http\Controllers;

use App\Divisa;
use App\Sale;
use App\Income; 
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $divisa = Divisa::latest('created_at')->take(1)->get();

        if($divisa->count()){
            $divisa_p = $divisa[0]->price;
        }else{
            $divisa_p = 0;
        }

        $yearNow = date('Y'); 
        
        $sales = Sale::byYearAndMonthSales()
                ->whereYear('created_at', $yearNow)  
                ->get();  
              
        $incomes = Income::byYearAndMonthIncomes()
                    ->whereYear('created_at', $yearNow)  
                    ->get();             

        
        if(request()->wantsJson())
        {
            return [
                'divisa_p' => $divisa_p,
                'sales' => $sales,
                'incomes' => $incomes
            ];    
        }
    }
}
