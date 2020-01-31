<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Item;
use App\News;
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
        $this->middleware('auth')->except("home");
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            return redirect(route("order.admin_index"));
        };
        return redirect(route("item.index"));
    }

    public function home()
    {
        $items=Item::orderBy('created_at', 'DESC')->take(6)->get();
        $news = News::orderBy('created_at', 'DESC')->take(3)->get();
        $ads = Ad::where("show_in_home", true)->orderBy('created_at', 'DESC')->take(3)->get();
        return view('home', ["ads" => $ads,"news"=>$news,"items"=>$items]);
    }

}
