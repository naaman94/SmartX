<?php

namespace App\Http\Controllers;

use App\Ad;
use Illuminate\Http\Request;

class AdController extends Controller
{
    /**
     * AdController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads = Ad::paginate(10);
        return view('pages.ad.index', compact("ads"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('pages.ad.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $attributes = request()->validate([
            'title' => ['required', "string", 'min:3'],
            'url' => ['string', 'nullable'],
            'image' => 'required|image|max:5000',
        ]);
        $attributes['show_in_home'] = array_key_exists('home', $request->show_in);
        $attributes['show_in_store'] = array_key_exists('store', $request->show_in);
        $attributes['show_in_items'] = array_key_exists('items', $request->show_in);

        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $attributes['image'] = uniqid() . '.' . $ext;
        $image->storeAs('public/storage/ads',$attributes['image']);

        Ad::create($attributes);
        session()->flash("message", "{$request->title} has been created as Ad.");
        return redirect()->route('ads.index');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Ad $ad
     * @return \Illuminate\Http\Response
     */
    public function show(Ad $ad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Ad $ad
     * @return \Illuminate\Http\Response
     */
    public function edit(Ad $ad)
    {
        
        return view('pages.ad.edit',['ad'=>$ad]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Ad $ad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ad $ad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Ad $ad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ad $ad)
    {

        $ad->delete();
        session()->flash("message", "ad has been Deleted.");
        return redirect()->route('ads.index');
    }
}
