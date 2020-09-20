<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except'=> 'login']); 
    }
   
   public function index()
   {
       return view('spa');
   }

   public function login()
   {
       return view('auth.login');
   }
   
}
