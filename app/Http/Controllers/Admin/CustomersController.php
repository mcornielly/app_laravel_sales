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
    public function index(Customer $customer, Request $request)
    {
        $this->authorize('view', $customer);

        $length = $request->input('length');
        $orderBy = $request->input('column'); //Index
        $orderByDir = $request->input('dir');
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

    public function select_customer(Request $request)
    {

        $filter = $request->filter;
        
        $customer = Customer::where('customers.name', 'like', '%' . $filter . '%')
            ->orWhere('customers.num_document', 'like', '%' . $filter . '%')
            ->select('customers.id', 'customers.name', 'customers.num_document')
            ->get();

        if(request()->wantsJson())
        {
            return $customer;
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
    public function store(Customer $customer, Request $request)
    {
        $this->authorize('create', $customer);
        
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
    public function update(Customer $customer, Request $request, $id)
    {
        $this->authorize('update', $customer);

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
