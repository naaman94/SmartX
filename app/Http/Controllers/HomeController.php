<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin')->only("admin_index");

        $this->middleware('auth')->except("welcome");
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->isAdmin()){
            return redirect(route("admin.home"));
        } ;
        return view('home');
    }
    public function welcome()
{
    return view('welcome');
}
    public function admin_index()
    {
        return view('adminHome');
    }
}
