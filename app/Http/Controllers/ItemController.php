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
        $categories = Category::all();
        $items=Item::all();
        return view('pages.items.index', compact(["categories","items"]));
    }

    public function admin_index()
    {
        $categories = Category::all();
        $items=Item::all();
        return view('pages.items.admin_index', compact(["categories","items"]));
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
        return redirect()->route('item.admin_index');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        $categories = Category::all();
        return view('pages.items.show',compact(["categories","item"]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $categories = Category::all();
        return view('pages.items.edit',compact(["categories","item"]));
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
        $attributes = request()->validate([
            'sku' => ['required', Rule::unique('items')->ignore($id), 'min:3'],
            'name' => ['required', 'min:3'],
            'description' => ['required', 'min:3'],
            'price' => ['required', 'numeric','integer' ],
            'discount' => ['nullable','numeric','between:0,100'],
            'status'=>['required','string'],
            'category_id'=>['required'],
        ]);
        $attributes['views'] = 0;
        if($request->image==null){
            $attributes['image'] ="no_img_item.jpg";
        }else
        {
            $attributes['image'] = $request->file('image')->getClientOriginalName();
            if ( $attributes['image']!="no_img_item.jpg"&& $attributes['image']!=item::find($id)->get()->image) {//ok here chech the get function
                //delete the old image
                $image = $request->file('image');
                $attributes['image'] = time() . '.' . $image->getClientOriginalExtension();
                Image::make($image)->save(public_path('/uploads/items_img/' . $attributes['image']));
            }
        }

        Item::find($id)->update($attributes);
        return redirect()->route('item.admin_index');
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
        return redirect()->route('item.admin_index');

//        return redirect('News')->with('success', 'Data is successfully deleted');
    }
}
