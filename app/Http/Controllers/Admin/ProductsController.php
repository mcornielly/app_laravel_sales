<?php

namespace App\Http\Controllers\Admin;

use App\Divisa;
use App\Product;
use App\Photo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Propiedades del DataTble
        $length = $request->input('length');
        $orderBy = $request->input('column'); //Index
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search');

        $query = Product::with('category')->withTrashed()->eloquentQuery($orderBy, $orderByDir, $searchValue);
                
        if(request()->wantsJson())
        {
            $data = $query->paginate($length);
            return new DataTableCollectionResource($data);
        }

        return view('admin.products.index', compact('products', 'divisa_p'));
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
        $data = $this->validate($request, [
                'name' => 'required|min:3',
                'category_id' => 'required|numeric|min:1',
                'code' => 'required',
                'cost_price' => 'required|numeric|min:1',
                'description' => 'required',
                'stock' => 'required|numeric|min:10',
                'margin_gain_u' => 'required|numeric',
                'divisa_unit' => 'required',
                'wholesale_quantity' => 'required|numeric|min:10',
                'margin_gain_w' => 'required',
                'wholesale_divisa' => 'required',
            ]);
        
        $product = new Product;
        $product->name = $request->name;    
        $product->category_id = $request->category_id;    
        $product->code = $request->code;
        $product->cost_price = $request->cost_price;    
        $product->description = $request->description;    
        $product->stock = $request->stock;    
        $product->margin_gain_u = $request->margin_gain_u;    
        $product->divisa_unit = $request->divisa_unit;    
        $product->wholesale_quantity = $request->wholesale_quantity;    
        $product->margin_gain_w = $request->margin_gain_w;    
        $product->wholesale_divisa = $request->wholesale_divisa;    
        $product->save();
        
        if(count($request->photos)>0){
            foreach($request->photos as $photo)
            {
                $photos = new Photo;  
                $photos->product_id = $product->id;  
                $photos->url = $photo;
                $photos->save();

            }
        }    

        

        if($data && request()->wantsJson())
        {
            return $product;
        }else{
            return $data;
        }

        return back()->with('message', 'La Divisa fue actualizada, con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::withTrashed()->find($id);
        $product->load('category');
 
        if(request()->wantsJson())
        {
            return $product;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if(!$request->ajax()) return redirect('/');

        $product = Product::withTrashed()->find($id);

        if(request()->wantsJson())
        {
           return $product; 
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Product $product, $id)
    {
        $data = $this->validate($request, [
            'name' => 'required|min:3',
            'category_id' => 'required',
            'code' => 'required',
            'cost_price' => 'required',
            'description' => 'required',
            'stock' => 'required',
            'margin_gain_u' => 'required',
            'divisa_unit' => 'required',
            'wholesale_quantity' => 'required',
            'margin_gain_w' => 'required',
            'wholesale_divisa' => 'required',
        ]);

        $product = Product::find($request->id);    
        $product->update($data);

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, $id)
    {
        $product = Product::find($id);
        $product->status = '0';
        $product->save();
        $product->delete();
 
        if(request()->wantsJson())
        {
            return $product;
   
        }
    }

    public function restore($id)
    {
       $product = Product::withTrashed()->find($id); 
       $product->status = '1';
       $product->save();
       $product->restore();

       if(request()->wantsJson())
       {
           return $product;
  
       }
    }

    public function last_id()
    {
        $product_id = Product::select('id')->latest('id')->first();

        return $product_id;
    }
}
