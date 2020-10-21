<?php

namespace App\Http\Controllers\Admin;

use App\Divisa;
use App\Category;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category, Request $request)
    {
        $this->authorize('view', $category);
        //Propiedades del DataTble
        $length = $request->input('length');
        $orderBy = $request->input('column'); //Index
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search');

        $query = Category::withTrashed()->eloquentQuery($orderBy, $orderByDir, $searchValue);

        if(request()->wantsJson())
        {
            $data = $query->paginate($length);
            return new DataTableCollectionResource($data);
        }

        return view('admin.categories.index', compact('categories'));
    }

    public function list_categories()
    {
        $categories = Category::withTrashed()->get();

        if(request()->wantsJson())
        {
            return $categories;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Category $category, Request $request)
    {
        $this->authorize('create', $category);

        $valido = $this->validate($request,[
            'name' => 'required',
            'description' => 'required'
        ]);
          
        $category = Category::create($request->all());
      
        if($valido && request()->wantsJson())
        {
            return $category;
        }else{
            return $valido;
        }

        return back()->with('message', 'La Categoría fue registrada, con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category,Request $request, $id)
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
    public function update(Category $category, Request $request, $id)
    {
        $this->authorize('update', $category);

        $valido = $this->validate($request,[
            'name' => 'required',
            'description' => 'required'
        ]);
        
        $category = Category::findOrFail($request->id); 
        $category->name = $request->name; 
        $category->url = Str::slug($request->name); 
        $category->description = $request->description; 
        $category->update();
      
        if($valido && request()->wantsJson())
        {
            return $category;
        }else{
            return $valido;
        }

        return back()->with('message', 'La Categoría fue registrada, con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, $id)
    {
        $this->authorize('delete', $category);

        $category = Category::findOrFail($id);
        $category->status = '0';
        $category->save();
        $category->delete();
 
        if(request()->wantsJson())
        {
            return $category;
   
        }
    }

    public function restore(Category $category, $id)
    {
        $this->authorize('restore', $category);

        $category = Category::withTrashed()->find($id); 
        $category->status = '1';
        $category->save();
        $category->restore();

       if(request()->wantsJson())
       {
           return $category;
  
       }
    }
}
