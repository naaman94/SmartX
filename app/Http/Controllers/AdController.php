<?php

namespace App\Http\Controllers;

use App\Ad;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }


    public function index()
    {
        $ads = Ad::orderBy('created_at', 'DESC')->paginate(10);
        return view('pages.ad.index', compact("ads"));
    }

    public function create()
    {

        return view('pages.ad.create');
    }

    public function store(Request $request)
    {
        $attributes = $this->Validation($request);
        $attributes['show_in_home'] = in_array('home', $request->show_in);
        $attributes['show_in_store'] = in_array('store', $request->show_in);
        $attributes['show_in_items'] = in_array('items', $request->show_in);
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $attributes['image'] = uniqid() . '.' . $ext;
        $image->storeAs('public/storage/ads', $attributes['image']);

        Ad::create($attributes);
        session()->flash("message", "an Ad {$request->title} has been created successfully.");
        return redirect()->route('ads.index');

    }

    public function edit(Ad $ad)
    {

        return view('pages.ad.edit', ['ad' => $ad]);

    }


    public function update(Request $request, Ad $ad)
    {
//        return $request;

        $attributes = $this->Validation($request);
        $attributes['show_in_home'] = in_array('home', $request->show_in);
        $attributes['show_in_store'] = in_array('store', $request->show_in);
        $attributes['show_in_items'] = in_array('items', $request->show_in);
        $attributes['image']=$ad->image;
        if ($request->hasFile('image')) {
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $attributes['image'] = uniqid() . '.' . $ext;
            $image->storeAs('public/storage/ads', $attributes['image']);
            Storage::delete("public/storage/ads/$request->org_image");
        }
//        return $attributes;

        $ad->update($attributes);
        session()->flash("message", "Ad {$request->title} has been edited successfully.");
        return redirect()->route('ads.index');
    }


    public function destroy(Ad $ad)
    {
        Storage::delete("public/storage/ads/$ad->image");
        $ad->delete();
        session()->flash("message", "Ad has been Deleted successfully.");
        return redirect()->route('ads.index');
    }

    public function Validation($request)
    {
        return request()->validate([
            'title' => ['required', "string", 'min:3'],
            'url' => ['string', 'nullable'],
            'image' => $request->input('org_image') ? 'image|max:5000' : 'required|image|max:5000'
        ]);
    }
}
