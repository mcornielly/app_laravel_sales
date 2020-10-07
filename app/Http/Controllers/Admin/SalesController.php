<?php

namespace App\Http\Controllers\Admin;

use App\Sale;
use App\DetailSale;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class SalesController extends Controller
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
        $orderByDir = $request->input('dir');
        $length = $request->input('length');

        $query = Sale::with('customer','user')->eloquentQuery($orderBy, $orderByDir, $searchValue);

        if(request()->wantsJson())
        {
            $data = $query->paginate($length);         
            return new DataTableCollectionResource($data);
        }

    }

    public function count_record(){
        $counter = Sale::all()->count();
        $counter = $counter + 1;
        $num_sale = str_pad($counter,6,"0",STR_PAD_LEFT);
        return $num_sale;
        
        if(request()->wantsJson())
        {
            return $num_sale;
        }
    }

    public function sale_pdf(Request $request, $id)
    {
 
        $sale = Sale::with('user','customer')
                ->join('customers','sales.customer_id','=','customers.id')
                ->select('sales.*','customers.name as customer_name','customers.type_document','customers.num_document','customers.num_phone','customers.email',
                'customers.address')
                ->where('sales.id', $id)
                ->orderBy('sales.id', 'DESC') 
                ->get();

        $detail_sales = DetailSale::join('products','detail_sales.product_id','products.id')
                    ->select('detail_sales.id','detail_sales.sale_id','detail_sales.product_id','detail_sales.type_sale','detail_sales.quantity','detail_sales.price as price_sale','detail_sales.discount','products.*')
                    ->where('detail_sales.sale_id', $id) 
                    ->orderBy('detail_sales.id', 'DESC')
                    ->get();
        
        //Vista del reporte PDF en el explorador             
        $num_sale = Sale::select('num_voucher')->where('id', $id)->get();
        // $pdf = \PDF::loadView('pdf.incomepdf', compact('income', 'detail_incomes'));
        $pdf = \PDF::loadView('pdf.invoice_sale_pdf', compact('sale', 'detail_sales')); 
        // $pdf->set_paper("a4", "portrait");
        // $pdf->render();            
        // $pdf = app('dompdf.wrapper');
        // $pdf->loadHTML($pdf);
        // $pdf->setOption('javascript-delay', 3000);
        return $pdf->stream('sale - '.$num_sale.'.pdf');
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
        $sale = new Sale;
        $sale->customer_id = $request->customer_id;
        $sale->user_id = $request->user_id;
        $sale->type_voucher = $request->type_voucher;
        $sale->num_voucher = $request->num_voucher;
        $sale->num_bill = $request->num_bill;
        $sale->tax = $request->tax;
        $sale->total = $request->total;
        $sale->save();
        
        //Detalle del Ingresdo
        $detail_sales = $request->detail_sales;

        
        //Recoremos los elementos
        if(count($detail_sales)>0){
            foreach($detail_sales as $detail) {
                $detail_sale = new DetailSale();
                $detail_sale->sale_id = $sale->id;
                $detail_sale->product_id = $detail['product_id'];
                $detail_sale->type_sale = $detail['type_sale'];
                $detail_sale->quantity = $detail['quantity'];
                $detail_sale->price = $detail['price'];
                $detail_sale->discount = $detail['discount'];
                $detail_sale->save();
            }
        }

        if(request()->wantsJson())
        {
            return $sale;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $sale = Sale::with('user','customer')->findOrFail($id);

        $detail_sales = DetailSale::join('products','detail_sales.product_id','products.id')
                    ->select('detail_sales.id','detail_sales.sale_id','detail_sales.product_id','detail_sales.type_sale','detail_sales.quantity','detail_sales.price as price_sale','detail_sales.discount','products.*')
                    ->where('detail_sales.sale_id', $id) 
                    ->orderBy('detail_sales.id', 'DESC')
                    ->get();
        if(request()->wantsJson())
        {
            return [
                'detail_sales' => $detail_sales,
                'sale' => $sale,
            ];
        }
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
        $sale = Sale::findOrFail($id);
        $sale->status = '0';
        $sale->save();

        if(request()->wantsJson())
        {
            return $sale;
        }
    }
}
