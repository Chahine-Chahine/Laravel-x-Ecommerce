<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function create_order(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user();

            $request->validate([
                'transaction_id' => 'required|exists:transactions,transaction_id',
                'cart_id' => 'required|exists:shoppingcarts,cart_id',
            ]);

            $order = Order::create([
                'user_id' => $user->user_id,
                'transaction_id' => $request->input('transaction_id'),
                'cart_id' => $request->input('cart_id'),   
            ]);

            return response()->json(['message' => 'Order created successfully']);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
