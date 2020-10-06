<?php

namespace App\Http\Controllers\Admin;
use App\Photo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $this->validate(request(),[
            'photo' => 'image|max:2048'
        ]);
        
        $photos = $request->file('photo')->store('product','public');
            
        $photoUrl = Storage::url($photos);

        if(request()->wantsJson()){
            return $photoUrl;
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
        $photos = Photo::where('product_id', $id)->get();

        if(request()->wantsJson()){
            return $photos;
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
    public function destroy(Request $request,$id)
    {
        if($request->ajax()){

            $photo = Photo::find($id);
            $photoPath = str_replace('storage', 'public', $photo->url);
            Storage::delete($photoPath);
            $photo->delete();
            
            return $photo;
        }
    }

    public function delete_storage(Request $request)
    {
        if($request->ajax()){

            if(count($request->photos)>0){
                foreach($request->photos as $photo)
                {
                    $photoPath = str_replace('storage', 'public', $photo);
    
                    Storage::delete($photoPath);
                }
            }
        
        }
    }
}
