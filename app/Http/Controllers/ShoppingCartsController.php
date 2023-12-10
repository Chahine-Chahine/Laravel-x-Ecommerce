<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShoppingCart;
use App\Models\CartItem;
use App\Models\Product;

class ShoppingCartsController extends Controller
{
    public function create_cart(Request $request)
    {
        $user = $request->user();

        $shoppingCart = new ShoppingCart();
        $shoppingCart->user_id = $user->user_id;
        $shoppingCart->save();

        $this->addDefaultItemsToCart($user);

        return response()->json(['message' => 'Shopping cart created successfully']);

    }

    public function read_cart(Request $request)
    {
        $user = $request->user();
        $shoppingCart = ShoppingCart::where('user_id', $user->user_id)->first();
        $cartItems = $shoppingCart->cartItems;
        return response()->json([
            'Carts' => $shoppingCart,
            'message' => 'shoppingCart desplayed successfully'
        ]);
    }

    public function deleteCart(Request $request)
    {
        $user = $request->user();
        $shoppingCart = ShoppingCart::where('user_id', $user->user_id)->first();

        $shoppingCart->cartItems()->delete();
        $shoppingCart->delete();

        return redirect()->route('dashboard')->with('success', 'Shopping cart deleted successfully.');
    }

    private function addDefaultItemsToCart($user)
    {
        $shoppingCart = ShoppingCart::where('user_id', $user->user_id)->first();

        $products = Product::limit(2)->get();

        foreach ($products as $product) {
            $cartItem = new CartItem();
            $cartItem->cart_id = $shoppingCart->cart_id;
            $cartItem->product_id = $product->product_id;
            $cartItem->quantity = 1;
            $cartItem->save();
        }
    }
}
