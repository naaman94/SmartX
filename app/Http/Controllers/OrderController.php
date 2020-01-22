<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('admin')->only(['destroy']);
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Order::whereUser_id(Auth::id())->whereNotIn('status', ["cart"])->get();
        return $data;
//        return view('pages.category.all_categories', compact("$data"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $order= Order::whereUser_id(Auth::id())->whereStatus('cart')->first();
        $total['qnt'] = 0;
        $total['after_dis'] = 0;
        foreach ($order->card as $card) {
            $total['qnt'] += $card->quantity;
            $total['after_dis'] += $card->quantity * ($card->item->price - $card->item->price * $card->item->discount / 100);
        }
         return view('pages.user.checkout', [ 'total' => $total,'order' => $order]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
   return $request;
//        return redirect()->route('order.index');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('pages.orders.show_order', ['data' => Order::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('pages.orders.edit_order', ['data' => Order::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $attributes=request()->validate([
            'country' => ['required', 'min:3'],
            'state' => ['required', 'min:3'],
            'city' => ['required', 'min:3'],
            'address' => ['required', 'min:3'],
            'phone' => ['required', 'numeric', 'integer'],
        ]);
        $attributes['status']="waiting to confirm";
        $order->update($attributes);
        return redirect()->route('order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Order:destroy($id);
        return redirect()->route('order.index');
    }
}
