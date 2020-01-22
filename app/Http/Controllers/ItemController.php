<?php

namespace App\Http\Controllers;

use App\Card;
use App\Category;
use App\Item;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Image;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except(['index', 'show']);
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        if (request("category") && request("category") != "all_item") {
            $items = Category::findOrFail(request("category"))->item;
        } else {
            $items = Item::all();
        }

        return view('pages.items.index', compact(["categories", "items"]));
    }

    public function admin_index()
    {
        $categories = Category::all();
        $items = Item::all();
        return view('pages.items.admin_index', compact(["categories", "items"]));
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
        $attributes = $this->ValidateItem();
        $attributes['views'] = 0;
        $attributes['image'] = "no_img_item.jpg";
        if ($request->hasfile('image')) {
            $image = $request->file('image');
            $attributes['image'] = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save(public_path('/storage/items_img/' . $attributes['image']));
        }
        Item::create($attributes);
        session()->flash("message", "{$request->name} item has been created.");
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
        $user = Auth::user();
        if ($user) {
            $order = Order::firstOrCreate(['user_id' => $user->id, 'status' => 'cart'],
                ['country' => $user->country,
                    'city' => $user->city,
                    'state' => $user->state,
                    'address' => $user->address,
                    'phone' => $user->phone,
                ]);
            $is_in_cart = Card::whereOrder_id($order->id)->whereItem_id($item->id)->first();
        } else {
            $is_in_cart = 1;
        }
        return view('pages.items.show', compact(["categories", "item", "is_in_cart"]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Item $item)
    {
        $this->authorize('update', $item);
        $categories = Category::all();
        return view('pages.items.edit', compact(["categories", "item"]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Item $item
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Item $item)
    {
        $this->authorize('update', $item);

        $attributes = $this->ValidateItem($item->id);
        $attributes['views'] = 0;
        if ($request->image == null) {
            $attributes['image'] = $request->org_image;
        } else {
//            $file_path = app_path("public/storage/items_img/{$request->org_image}");
//            if(File::exists($file_path)) dd(File::delete($file_path));
//should delete
            $attributes['image'] = $request->file('image')->getClientOriginalName();
            if ($attributes['image'] != "no_img_item.jpg" && $attributes['image'] != $item->image) {//ok here chech the get function
                //delete the old image
                $image = $request->file('image');
                $attributes['image'] = time() . '.' . $image->getClientOriginalExtension();
                Image::make($image)->save(public_path('/storage/items_img/' . $attributes['image']));
            }
        }
        $item->update($attributes);
        session()->flash("message", "{$request->name} item has been successfully Edit.");
        return redirect()->route('item.show', ['id' => $item->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);

        $item->delete();
        session()->flash("message", "Item has been Successfully Deleted.");
        return redirect()->route('item.admin_index');

//        return redirect('News')->with('success', 'Data is successfully deleted');
    }

    /**
     * @return mixed
     */
    public function ValidateItem($id = 0)
    {
        return request()->validate([
            'sku' => ['required', Rule::unique('items')->ignore($id), 'min:3'],
            'name' => ['required', 'min:3'],
            'description' => ['required', 'min:3'],
            'price' => ['required', 'numeric', 'integer'],
            'discount' => ['nullable', 'numeric', 'between:0,100'],
            'status' => ['required', 'string'],
            'category_id' => ['required'],
        ]);
    }
}
