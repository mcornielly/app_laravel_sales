<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\Divisa;
use App\Provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $length = $request->input('length');
        $orderBy = $request->input('column'); //Index
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search');
        
        $query = Customer::eloquentQuery($orderBy, $orderByDir, $searchValue);
        
        if(request()->wantsJson())
        {
            $data = $query->paginate($length);         
            return new DataTableCollectionResource($data);
        }

        $customers = $query;

        return view('admin.customers.index', compact('customers'));
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
        $valido = $this->validate($request,[
            'name' => 'required|min:3|unique:customers',
            'type_document' => 'required',
            'num_document' => 'required',
            'num_phone' => 'required',
            'email' => 'required|email|unique:customers',
            'address' => 'required',
        ]);

        $customer = Customer::create($request->all());   

        if($valido && request()->wantsJson())
        {
            return $customer;
        }else{
            return $valido;
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
        return Provider::with('customer')->find($id);
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
        $valido = $this->validate($request,[
            'name' => 'required|unique:customers,name,'. $request->id,
            'type_document' => 'required',
            'num_document' => 'required',
            'num_phone' => 'required',
            'email' => 'required|email|unique:customers,email,'. $request->id,
            'address' => 'required'
        ]);

        $customer = Customer::findOrFail($request->id);
        $customer->update($request->all());  

        if($valido && request()->wantsJson())
        {
            return $customer;
        }else{
            return $valido;
        }
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
