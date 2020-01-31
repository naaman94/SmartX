<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Card;
use App\Category;
use App\Item;
use App\Order;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    public $categories;

    public function __construct()
    {
        $this->categories= Category::orderBy('name', 'ASC')->get();
        $this->middleware('admin')->except(['index', 'show']);
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $ads = Ad::where("show_in_store", true)->orderBy('created_at', 'DESC')->take(3)->get();

        $categories = $this->categories;
        if (request("category") && request("category") != "all_item") {
            $items=Item::orderBy('name', 'ASC')->whereCategory_id(request("category"))->paginate(21);
        } else {
            $items = Item::orderBy('name', 'ASC')->paginate(21);
        }
        return view('pages.items.index', compact(["categories", "items","ads"]));
    }
    public function admin_index()
    {
        $categories = $this->categories;
        $items = Item::orderBy('name', 'ASC')->paginate(15);;
        return view('pages.items.admin_index', compact(["categories", "items"]));
    }


    public function create()
    {
        return view('pages.items.create', ['categories' =>$this->categories]);
    }


    public function store(Request $request)
    {
        $attributes = $this->ValidateItem();
        $attributes['image'] = "no_img_item.jpg";
        if ($request->hasFile('image')) {
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $attributes['image'] = uniqid() . '.' . $ext;
            $image->storeAs('public/storage/items', $attributes['image']);
        }
        Item::create($attributes);
        session()->flash("message", "{$request->name} item has been created.");
        return redirect()->route('item.admin_index');

    }


    public function show(Item $item)
    {
        $ads = Ad::where("show_in_items", true)->orderBy('created_at', 'DESC')->take(3)->get();

        $categories = $this->categories;
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
            $is_in_cart = null;
        }
        return view('pages.items.show', compact(["categories", "item", "is_in_cart",'ads']));
    }


    public function edit(Item $item)
    {
        $this->authorize('update', $item);
        $categories = $this->categories;
        return view('pages.items.edit', compact(["categories", "item"]));
    }


    public function update(Request $request, Item $item)
    {
        $this->authorize('update', $item);
        $attributes = $this->ValidateItem($item->id);
        if ($request->hasFile('image')) {
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $attributes['image'] = uniqid() . '.' . $ext;
            //upload the image
            $image->storeAs('public/storage/items', $attributes['image']);
            //delete the previous image.
            Storage::delete("public/storage/items/$request->org_image");
            //this column has a default value so don't need to set it empty.
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
     * @throws AuthorizationException
     */
    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);
        Storage::delete("public/storage/items/$item->image");
        $item->delete();
        session()->flash("message", "Item has been Successfully Deleted.");
        return redirect()->route('item.admin_index');
    }


    public function ValidateItem($id = 0)
    {
        return request()->validate([
            'sku' => ['required', Rule::unique('items')->ignore($id), 'min:3'],
            'name' => ['required', 'min:3'],
            'description' => ['nullable', 'string'],
            'short_description' => ['nullable', 'max:40'],
            'image' => 'nullable|image|max:5000',
            'price' => ['required', 'numeric', 'integer'],
            'discount' => ['nullable', 'numeric', 'between:0,100'],
            'status' => ['required', 'string','in:Available,Coming Soon,Out of Stock'],
            'category_id' => ['required',"exists:categories,id"]
        ]);
    }
}
