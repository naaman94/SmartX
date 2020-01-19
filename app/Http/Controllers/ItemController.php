<?php

namespace App\Http\Controllers;

use App\Category;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Image;
class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except(['index', 'show']);
        $this->middleware('auth')->except(['index', 'show']);    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Item::all();
        return view('pages.items.all_items', compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.items.create', ['categories' => Category::all()]);

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
            'sku' => ['required','unique:items', 'min:3'],
            'name' => ['required', 'min:3'],
            'description' => ['required', 'min:3'],
            'price' => ['required', 'numeric','integer' ],
            'discount' => ['nullable','numeric','between:0,100'],
            'status'=>['required','string'],
            'category_id'=>['required'],

        ]);
        $attributes['views'] = 0;
        $attributes['image'] = "no_img_item.jpg";
        if ($request->hasfile('image')) {
            $image = $request->file('image');
            $attributes['image']  = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save(public_path('/uploads/items_img/' . $attributes['image'] ));
        }
        Item::create($attributes);
        
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('pages.items.show_item', ['data' => Item::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('pages.items.edit', ['data' => Item::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $filename = $request->file('image')->getClientOriginalName();
        if ( $filename!="no_img_item.jpg"&& $filename!=item::find($id)->get()->image) {//ok here chech the get function
          //delete the old image
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save(public_path('/uploads/items_img/' . $filename));
        }

        Item::find($id)->update([
            'sku' => $request->sku,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $filename,
            'price' => $request->price,
            'discount' => $request->discount,
            'views' => $request->views,
            'status' => $request->status,
            'category_id' => $request->category_id,
        ]);
        return redirect()->route('item.show', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Item::destroy($id);
        return redirect()->route('item.index');

//        return redirect('News')->with('success', 'Data is successfully deleted');
    }
}
