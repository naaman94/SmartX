<?php

namespace App\Http\Controllers;

use App\Card;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
//        $user_id = Auth::id();
//        $data = card::all();
//        $news = News::all()->take(10);//return the top news art
//        return view('pages.category.all_categories', compact("$data"));
    }

    public function store(Request $request)
    {   $user = Auth::user();
        $order = Order::firstOrCreate(['user_id' => $user->id, 'state' => 'awaiting'],
            ['country' => $user->country,
            'city' => $user->city,
            'state' => $user->state,
            'address' => $user->address,
            'phone' => $user->phone,
        ]);

        Card::create([
            'item_id' => $request->item_id,
            'quantity' => $request->quantity,
            'order_id'=>$order->id
        ]);
        return back()->withInput();
    }


    public function update(Request $request, $id)
    {
        Card::find($id)->update([
            'item_id' => $request->item_id,
            'quantity' => $request->quantity,
            'order_id'=>$request->order_id]);
        return back()->withInput();
    }

    public function destroy($id)
    {
        Card::destroy($id);
        return back()->withInput();
//        return redirect('News')->with('success', 'Data is successfully deleted');
    }

}
