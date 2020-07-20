<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Divisa;
use App\Income;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

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
        
        $data = Income::with('user','provider')
            ->join('customers','incomes.provider_id','=','customers.id')
            ->select('incomes.*','customers.name as customer_name') 
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
        //
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
        //
    }
}
