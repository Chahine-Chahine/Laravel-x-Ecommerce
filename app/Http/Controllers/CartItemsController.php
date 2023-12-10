<?php

// CartItemController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;

class CartItemsController extends Controller
{
    public function addToCart(Request $request, $productId)
    {
        $user = $request->user();
        $shoppingCart = ShoppingCart::where('user_id', $user->id)->first();
        $product = Product::find($productId);

        $cartItem = new CartItem();
        $cartItem->cart_id = $shoppingCart->id;
        $cartItem->product_id = $product->id;
        $cartItem->quantity = 1;
        $cartItem->save();

        return redirect()->route('cart.view')->with('success', 'Item added to cart successfully.');
    }

    public function removeFromCart(Request $request, $cartItemId)
    {
        $cartItem = CartItem::find($cartItemId);
        $cartItem->delete();

        return redirect()->route('cart.view')->with('success', 'Item removed from cart successfully.');
    }
}
