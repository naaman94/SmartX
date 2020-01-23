<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct()
    {
        $this->middleware('admin')->only(['destroy', "admin_index"]);
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = $this->Total_price_Orders(Order::whereUser_id(Auth::id())->whereNotIn('status', ["cart"])->get());
        return view('pages.user.order_history', compact("orders"));
    }

    public function admin_index()
    {
        $orders = $this->Total_price_Orders(Order::whereNotIn('status', ["cart"])->get());
        return view('pages.order.admin_order', compact("orders"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $order = Order::whereUser_id(Auth::id())->whereStatus('cart')->first();
        $total = $this->total_price_cards($order->card);
        return view('pages.user.checkout', ['total' => $total, 'order' => $order]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $order = Order::whereUser_id(Auth::id())->whereStatus('cart')->first();
        $attributes = request()->validate([
            'country' => ['required', 'min:3'],
            'state' => ['required', 'min:3'],
            'city' => ['required', 'min:3'],
            'address' => ['required', 'min:3'],
            'phone' => ['required', 'numeric']
        ]);
        $attributes['status'] = "Order Processing";
        $attributes['created_at'] = time();
        $order->update($attributes);
        return redirect()->route('order.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('pages.orders.show_order', ['data' => Order::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
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
     * @return Response
     */
    public function update(Request $request, Order $order)
    {

        $attributes = request()->validate([
            'status' => ['required', "in_array[]"],
        ]);
        $order->update($attributes);
        return redirect()->route('order.admin_index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        Order:
        destroy($id);
        return redirect()->route('order.index');
    }

    /**
     * @param $orders
     * @return mixed
     */
    protected function Total_price_Orders($orders)
    {
        $i = 0;
        foreach ($orders as $order) {
            $total = $this->total_price_cards($order->card);
            $orders[$i]->qnt = $total['qnt'];
            $orders[$i++]->total = $total['after_dis'];
        }
        return $orders;
    }

    /**
     * @param $cards
     * @return mixed
     */
    protected function Total_price_cards($cards)
    {
        $total['qnt'] = 0;
        $total['after_dis'] = 0;
        foreach ($cards as $card) {
            $total['qnt'] += $card->quantity;
            $total['after_dis'] += $card->quantity * ($card->item->price - $card->item->price * $card->item->discount / 100);
        }
        return $total;
    }
}
