<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Income;
use App\DetailIncome;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;
use Barryvdh\DomPDF\PDF;
use Dompdf\Dompdf;

class IncomesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        //Propiedades del DataTble
        $searchValue = $request->input('search');
        $orderBy = $request->input('column'); //Index
        $orderBydir = $request->input('dir');
        $length = $request->input('length');

        // $query = Income::with('provider','user','customer')->eloquentQuery($orderBy, $orderBydir, $searchValue);
        
        $data = Income::with('user','provider','detail_incomes')
            ->join('customers','incomes.provider_id','=','customers.id')
            ->select('incomes.*','customers.name as customer_name','customers.type_document','customers.num_document','customers.num_phone','customers.email',
                    'customers.address') 
            ->where("incomes.id", "LIKE", "%$searchValue%")
            ->orWhere('customers.name', "LIKE", "%$searchValue%")
            ->orWhere('incomes.type_voucher', "LIKE", "%$searchValue%")
            ->orWhere('incomes.num_voucher', "LIKE", "%$searchValue%")
            ->orWhere('incomes.num_bill', "LIKE", "%$searchValue%")
            ->orWhere('incomes.total', "LIKE", "%$searchValue%")
            ->orWhere('incomes.status', "LIKE", "%$searchValue%")
            ->orderBy($orderBy, $orderBydir)
            ->paginate($length);

        if(request()->wantsJson())
        {
            // $data = $query->paginate($length);         
            return new DataTableCollectionResource($data);
        }

    }

    public function get_detail($id)
    {
        $detail_incomes = DetailIncome::join('products','detail_incomes.product_id','products.id')
                    ->select('detail_incomes.*','products.*')
                    ->where('detail_incomes.income_id', $id) 
                    ->orderBy('detail_incomes.id', 'DESC')
                    ->get();

        return ['detail_incomes' => $detail_incomes];
    }

    public function count_record(){
        $counter = Income::all()->count();
        $counter = $counter + 1;
        $num_invoice = str_pad($counter,6,"0",STR_PAD_LEFT);
        return $num_invoice;
        
        if(request()->wantsJson())
        {
            return $num_invoice;
        }
    }

    public function income_pdf(Request $request, $id)
    {
 
        $income = Income::with('user','provider','detail_incomes')
                ->join('customers','incomes.provider_id','=','customers.id')
                ->select('incomes.*','customers.name as customer_name','customers.type_document','customers.num_document','customers.num_phone','customers.email',
                'customers.address')
                ->where('incomes.id', $id)
                ->orderBy('incomes.id', 'DESC') 
                ->get();

        $detail_incomes = DetailIncome::join('products','detail_incomes.product_id','products.id')
                    ->select('detail_incomes.*','products.*')
                    ->where('detail_incomes.income_id', $id) 
                    ->orderBy('detail_incomes.id', 'DESC')
                    ->get();
        
        //Vista del reporte PDF en el explorador             
        $num_income = Income::select('num_voucher')->where('id', $id)->get();
        // $pdf = \PDF::loadView('pdf.incomepdf', compact('income', 'detail_incomes'));
        $pdf = \PDF::loadView('pdf.invoicepdf', compact('income', 'detail_incomes')); 
        // $pdf->set_paper("a4", "portrait");
        // $pdf->render();            
        // $pdf = app('dompdf.wrapper');
        // $pdf->loadHTML($pdf);
        // $pdf->setOption('javascript-delay', 3000);
        return $pdf->stream('income - '.$num_income.'.pdf');
        // return $pdf->download('income - '.$num_income.'.pdf');
        
        //Reporte de PDF download -------------------------------------------           
        // $num_income = Income::select('num_voucher')->where('id', $id)->get();
        // $pdf = \PDF::loadView('pdf.invoicepdf', compact('income', 'detail_incomes'))->render();
        // return $pdf->download('income - '.$num_income.'.pdf'); 
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $income = new Income;
        $income->provider_id = $request->provider_id;
        $income->user_id = $request->user_id;
        $income->type_voucher = $request->type_voucher;
        $income->num_voucher = $request->num_voucher;
        $income->num_bill = $request->num_bill;
        $income->tax = $request->tax;
        $income->total = $request->total;
        $income->save();
        
        //Detalle del Ingresdo
        $detail_incomes = $request->detail_incomes;
        
        //Recoremos los elementos
        if(count($detail_incomes)>0){
            foreach($detail_incomes as $detail) {
                $detail_income = new DetailIncome();
                $detail_income->income_id = $income->id;
                $detail_income->product_id = $detail['product_id'];
                $detail_income->price = $detail['price'];
                $detail_income->quantity = $detail['quantity'];
                $detail_income->save();
            }
        }

        if(request()->wantsJson())
        {
            return $income;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $income = Income::findOrFail($id);
        $income->status = '0';
        $income->save();

        if(request()->wantsJson())
        {
            return $income;
        }
    }
}
