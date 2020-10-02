<?php

namespace App\Http\Controllers\Admin;

use App\Divisa;
use App\Product;
use App\Photo;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
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

        if($request->price == true){
            $query = Product::with('category')->withTrashed()->eloquentQuery($orderBy, $orderByDir, $searchValue)
            ->where('products.price', '>', 0);
        }else{
            $query = Product::with('category')->withTrashed()->eloquentQuery($orderBy, $orderByDir, $searchValue);
        }
                
        if(request()->wantsJson())
        {
            $data = $query->paginate($length);
            return new DataTableCollectionResource($data);
        }

        //return view('admin.products.index', compact('products', 'divisa_p'));
    }

    public function priceslist(Request $request)
    {
        //Propiedades del DataTble
        $length = $request->input('length');
        $orderBy = $request->input('column'); //Index
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search');

        $query = Product::with('category')->withTrashed()->eloquentQuery($orderBy, $orderByDir, $searchValue)
        ->where('products.price', '>', 0);
        // $query = Product::with('category')->withTrashed()->eloquentQuery($orderBy, $orderByDir, $searchValue)
               
        if(request()->wantsJson())
        {
            $data = $query->paginate($length);
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

    public function validate_step(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|min:3|unique:products',
            'category_id' => 'required|numeric|min:1',
            'description' => 'required',
        ]);

    }


    public function validate_code(Request $request)
    {

        $this->validate($request, [
            'code' => 'required|numeric|min:13|unique:products',
        ]);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        
        $product = Product::create($request->all());
        // $product = new Product;
        // $product->name = $request->name;    
        // $product->category_id = $request->category_id;    
        // $product->code = $request->code;
        // $product->description = $request->description;    
        // $product->user_id = $request->user_id;
        // $product->save();
        
        if(count($request->photos)>0){
            foreach($request->photos as $photo)
            {
                $photos = new Photo;  
                $photos->product_id = $product->id;  
                $photos->url = $photo;
                $photos->save();

            }
        }    

        if(request()->wantsJson())
        {
            return $product;

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
        $product = Product::with('category')->withTrashed()->find($id);
 
        if(request()->wantsJson())
        {
            return $product;
        }
    }

    public function product_search($code)
    {

        $product = Product::with('category','photos')
                    ->withTrashed()
                    ->where('code', $code)
                    ->get();
        
        if(request()->wantsJson())
        {
            return ['product' => $product];
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
        // return $request->all();
        // $data = $request->all();
        $data = $this->validate($request,[
            'name' => 'required|min:3|unique:products,id,' . $request->id,
            'category_id' => 'required|numeric|min:1',
            'description' => 'required',
            'code' => 'required',
            // 'price' => 'required|numeric|not_in:0',
            // 'stock' => 'required|numeric|not_in:0',
            // 'wholesale_quantity' => 'required|numeric|not_in:0',
        ]);

        $product = Product::find($request->id);    
        $product->update($data);

        if(count($request->photos)>0){
            foreach($request->photos as $photo)
            {
                $photos = new Photo;  
                $photos->product_id = $request->id;  
                $photos->url = $photo;
                $photos->save();

            }
        }  

        return $product;
    }

    public function update_cost(Request $request){
        $product = Product::find($request->id);
        $product->update($request->all());

        if(request()->wantsJson())
        {
            return $product;
        }
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
