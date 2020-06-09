<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Divisa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class DivisaController extends Controller
{
    public function index(Request $request)
    {
        $length = $request->input('length');
        $orderBy = $request->input('column'); //Index
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search');

        $query = Divisa::with('user')->eloquentQuery($orderBy, $orderByDir, $searchValue);
        // $query->load('user');
        
        if(request()->wantsJson())
        {
            $data = $query->paginate($length);         
            return new DataTableCollectionResource($data);
        }

        $divisas = $query;

        return view('admin.divisas.index', compact('divisas'));
    }

    public function getDivisa()
    {
        $divisa = Divisa::latest('price')->take(1)->get(); 
       
        if($divisa->count()){
            $divisa_p = $divisa[0]->price;
        }else{
            $divisa_p = 0;
        } 

    }

    public function store(Request $request)
    {
        $valido = $this->validate($request, [
            'price' => 'required|numeric'
        ]);
        
        $divisa = Divisa::create($request->all());
        
        if($valido && request()->wantsJson())
        {
            return $divisa;
        }else{
            return $valido;
        }

        return back()->with('message', 'La Divisa fue actualizada, con exito');
    }

    public function update(Divisa $divisa, Request $request)
    {
  
        $valido = $this->validate($request, [
            'price' => 'required|numeric'
        ]);

        $divisa->update($request->all());
        
        if($valido && request()->wantsJson())
        {
            return $divisa;
        }else{
            return $valido;
        }

        return back()->with('message', 'El precio fue actualizado.');

    }
}
