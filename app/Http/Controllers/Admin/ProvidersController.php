<?php

namespace App\Http\Controllers\Admin;

use App\Divisa;
use App\Provider;
use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class ProvidersController extends Controller
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
        $orderBydir = $request->input('dir', 'desc');
        $searchValue = $request->input('search');
        
        // $query = Provider::eloquentQuery($orderBy, $orderByDir, $searchValue);
        // $query = Provider::with('customer')->eloquentQuery($orderBy, $orderByDir, $searchValue)
        //             ->select('customers.*','providers.name as provider_name','provider.contact_phone','provider.id');
        
        $data = Provider::join('customers','providers.id','=','customers.id')
        ->select('customers.*','providers.id as provider_id','providers.name as contact_name','providers.contact_phone') 
        ->where("providers.id", "LIKE", "%$searchValue%")
        ->orWhere('customers.name', "LIKE", "%$searchValue%")
        ->orWhere('customers.type_document', "LIKE", "%$searchValue%")
        ->orWhere('customers.num_document', "LIKE", "%$searchValue%")
        ->orWhere('customers.num_phone', "LIKE", "%$searchValue%")
        ->orWhere('customers.email', "LIKE", "%$searchValue%")
        ->orderBy($orderBy, $orderBydir)
        ->paginate($length);


        if(request()->wantsJson())
        {
            // $data = $query->paginate($length);         
            return new DataTableCollectionResource($data);
        }

        $customers = $query;

        return view('admin.providers.index', compact('providers'));
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
            'contact_name' => 'required', 
            'user_id' => 'required', 
            'contact_phone' => 'required', 
        ]);  

            $customer = Customer::create($request->all());

            $request['id'] = $customer->id;
            $request['name'] = $request->contact_name;

            $provider = Provider::create($request->all());

            // $data = [
            //     'customer' => $customer,
            //     'provider' => $provider,
            // ];
            
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
    public function show(Request $request, $id)
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
            'name' => 'required|unique:customers,name,'. $request->customer_id,
            'type_document' => 'required',
            'num_document' => 'required',
            'num_phone' => 'required',
            'email' => 'required|email|unique:customers,email,'. $request->customer_id,
            'address' => 'required',
            'name' => 'required|unique:providers,name,'. $request->id, 
            'contact_phone' => 'required', 
            'user_id' => 'required', 
        ]);
        
        $customer = Customer::findOrFail($request->customer_id);
        $customer->name = $request->name;
        $customer->type_document = $request->type_document;
        $customer->num_document = $request->num_document;
        $customer->num_phone = $request->num_phone;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->user_id = $request->user_id;
        $customer->update();    
        
        $provider = Provider::findOrFail($request->customer_id);
        $provider->name = $request->name_contact;
        $provider->contact_phone = $request->contact_phone;
        $provider->update();
        
        
        return $valido;

        if($valido && request()->wantsJson())
        {
            return $customer;
        }else{
            return $valido;
        }
    }

    public function select_provider(Request $request)
    {

        $filter = $request->filter;
        
        $providers = Provider::join('customers', 'providers.id', 'customers.id')
            ->where('customers.name', 'like', '%' . $filter . '%')
            ->orWhere('customers.num_document', 'like', '%' . $filter . '%')
            ->select('customers.id', 'customers.name', 'customers.num_document')
            ->get();

        // $providers = Provider::join('customers', 'providers.id', 'customers.id')
        //                 ->select('customers.id', 'customers.name', 'customers.num_document')
        //                 ->get();

        
        if(request()->wantsJson())
        {
            return $providers;
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
