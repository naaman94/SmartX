<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('admin')->only(['edit','update','destroy']);
        $this->middleware('auth');
    }

    public function index()
    {
        $user_id = Auth::id();
        $data = Order::whereUser_id($user_id)->where('status', '!=', 'card')->get();
//        return view('pages.category.all_categories', compact("$data"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = Auth::id();
        $data = Order::whereUser_id($user_id)->whereStatus('card')->first();
        return view('pages.order.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Order::find($request->id)->update([
            'country' => $request->country,
            'city' => $request->city,
            'state' => $request->state,
            'address' => $request->address,
            'phone' => $request->phone,
            'status'=>'awaiting',
        ]);
        return redirect()->route('order.index');

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
    public function update(Request $request, $id)
    {
        Order::find($id)->update([
            'status'=>$request->status
        ]);
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
