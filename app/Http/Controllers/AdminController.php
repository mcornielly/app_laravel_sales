<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }
   
   public function index()
   {
       return view('spa_app');
   }

   public function login()
   {
        return view('auth.login');
   }
   
}
