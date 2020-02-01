<?php

namespace App\Http\Controllers;

use App\Card;
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
    public $status_form_array = ['Order Processing', 'Order Shipping', 'Order Delivered', 'Order Reject', 'We will contact with you soon', 'The order details has been sent to the e-mail'];

    public function __construct()
    {
        $this->middleware('admin')->only(['update', "admin_index"]);
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = $this->Total_price_Orders(Order::whereUser_id(Auth::id())->whereNotIn('status', ["cart"])->orderBy('created_at', 'DESC')->paginate(20));
        return view('pages.order.order_history', compact("orders"));
    }

    public function admin_index()
    {
        $sort_by_arr = ["Time: newly listed",
            "Time: the oldest",
            "ID lowest first",
            "ID highest first",
            "Status is Order Processing",
            "Status is Order Shipping",
            "Status is Order Delivered",
            "Status is Order Reject",
            "Other status"
        ];
        switch (request("sort_by")) {
            case "ID lowest first":
                $sort = "id";
                $order = "ASC";
                break;
            case "ID highest first":
                $sort = "id";
                $order = "DESC";
                break;

            case "Time: the oldest":
                $sort = "created_at";
                $order = "ASC";
                break;
            case "Status is Order Processing":
                $orders = $this->Total_price_Orders(Order::whereStatus("Order Processing")->orderBy("created_at", "DESC")->paginate(20));
                return view('pages.order.admin_order', ['sort_by_arr' => $sort_by_arr,'orders' => $orders, 'status_form_array' => $this->status_form_array]);
                break;
            case "Status is Order Shipping":
                $orders = $this->Total_price_Orders(Order::whereStatus("Order Shipping")->orderBy("created_at", "DESC")->paginate(20));
                return view('pages.order.admin_order', ['sort_by_arr' => $sort_by_arr,'orders' => $orders, 'status_form_array' => $this->status_form_array]);
                break;
            case "Status is Order Delivered":
                $orders = $this->Total_price_Orders(Order::whereStatus("Order Delivered")->orderBy("created_at", "DESC")->paginate(20));
                return view('pages.order.admin_order', ['sort_by_arr' => $sort_by_arr,'orders' => $orders, 'status_form_array' => $this->status_form_array]);
                break;
            case "Status is Order Reject":
                $orders = $this->Total_price_Orders(Order::whereStatus("Order Reject")->orderBy("created_at", "DESC")->paginate(20));
                return view('pages.order.admin_order', ['sort_by_arr' => $sort_by_arr,'orders' => $orders, 'status_form_array' => $this->status_form_array]);
                break;
            case "Other status":
                $orders = $this->Total_price_Orders(Order::whereNotIn('status', ["cart","Order Processing","Order Shipping","Order Delivered","Order Reject"])->orderBy("created_at", "DESC")->paginate(20));
                return view('pages.order.admin_order', ['sort_by_arr' => $sort_by_arr,'orders' => $orders, 'status_form_array' => $this->status_form_array]);
                break;
            case "Time: newly listed":
            default :
                $sort = "created_at";
                $order = "DESC";
                break;
        }

        $orders = $this->Total_price_Orders(Order::whereNotIn('status', ["cart"])->orderBy($sort, $order)->paginate(20));
        return view('pages.order.admin_order', ['sort_by_arr' => $sort_by_arr,'orders' => $orders, 'status_form_array' => $this->status_form_array]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $order = Order::whereUser_id(Auth::id())->whereStatus('cart')->first();
        $cards = Card::whereOrder_id($order->id)->paginate(20);
        $total = $this->Total_price_in_cards($order->card);
        return view('pages.order.checkout', ['total' => $total, 'cards' => $cards, 'order' => $order]);
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
            'phone' => ['required', 'regex:/^[0-9+]*$/', 'max:15'],
            'country' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
        ]);
        $attributes['status'] = "Order Processing";
        $attributes['created_at'] = time();
        $order->update($attributes);//we use update because it create in cardController
        session()->flash("message", " Order has been confirmed.");

        return redirect()->route('order.index');
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
//update status only
        $attributes = request()->validate([
            'status' => ["in:" . implode(',', $this->status_form_array)],
        ]);
        $old_status = $order->status;
        $order->update($attributes);
        session()->flash("message", " order {$order->id} status has been update  from {$old_status} to {$attributes['status']} .");
        return redirect()->route('order.admin_index');
    }

    /**
     * @param $orders
     * @return mixed
     */
    protected function Total_price_Orders($orders)
    {
        $i = 0;
        foreach ($orders as $order) {
            $total = $this->Total_price_in_cards($order->card);
            $orders[$i]->qnt = $total['qnt'];
            $orders[$i++]->total = $total['after_dis'];
        }
        return $orders;
    }

    /**
     * @param $cards
     * @return mixed
     */
    protected function Total_price_in_cards($cards)
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
