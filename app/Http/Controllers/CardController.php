<?php

namespace App\Http\Controllers;

use App\Card;
use App\Item;
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
        $user=Auth::user();
        $cards = Order::firstOrCreate(['user_id' => $user->id, 'status' => 'cart'],
            ['country' => $user->country,
                'city' => $user->city,
                'state' => $user->state,
                'address' => $user->address,
                'phone' => $user->phone,
            ])
            ->card;
        $total['qnt'] = 0;
        $total['price'] = 0;
        $total['after_dis'] = 0;
        foreach ($cards as $card) {
            $total['qnt'] += $card->quantity;
            $total['price'] += $card->quantity * $card->item->price;
            $total['after_dis'] += $card->quantity * ($card->item->price - $card->item->price * $card->item->discount / 100);
        }
        $total['discount'] = $total['price'] - $total['after_dis'];
        return view('pages.user.cart', ['total' => $total, 'cards' => $cards]);
    }

    public function store(Request $request)

    {
        $attributes = request()->validate([
            'item_id' => ['required', 'exists:items,id'],
            'quantity' => ['required', 'numeric', 'between:0,100'],
        ]);
        $user = Auth::user();
        $order = Order::firstOrCreate(['user_id' => $user->id, 'status' => 'cart'],
            ['country' => $user->country,
                'city' => $user->city,
                'state' => $user->state,
                'address' => $user->address,
                'phone' => $user->phone,
            ]);
        $attributes['order_id'] = $order->id;
        $card=Card::whereOrder_id($order->id)->whereItem_id($attributes['item_id'])->first();
        if ($card) {
            $card->update(['quantity' => $attributes['quantity']+$card->quantity]);
        } else {
            Card::create($attributes);
        }
        return redirect()->route('card.index');
    }

    public function update(Request $request, Card $card)
    {
        $attributes = request()->validate([
            'quantity' => ['required', 'numeric', 'between:0,100'],
        ]);
        if ($attributes['quantity'] == 0) {
            $card->delete();

        }
        $card->update(['quantity' => $attributes['quantity']]);
        return redirect()->route('card.index');
    }

    public function destroy(Card $card)
    {
        $card->delete();
        return redirect()->route('card.index');
    }

}
