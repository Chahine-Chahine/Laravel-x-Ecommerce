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
    if ($request->user()) {
        $user = $request->user();

        $shoppingCart = ShoppingCart::where('user_id', $user->user_id)->first();

        if (!$shoppingCart) {
            return response()->json(['error' => 'Shopping cart not found'], 404);
        }

        $cartItems = $shoppingCart->cartItems;

        $productsInCart = [];
        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product; 
            $productsInCart[] = [
                'cart_item_id' => $cartItem->cart_item_id,
                'product_id' => $product->product_id,
                'product_name' => $product->product_name,
                'description' => $product->description,
                'price' => $product->price,
                'quantity' => $cartItem->quantity,
            ];
        }

        return response()->json([
            'shopping_cart' => $shoppingCart,
            'products_in_cart' => $productsInCart,
            'message' => 'Shopping cart and products displayed successfully',
        ]);
    } else {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}


    public function delete_cart(Request $request)
    {
        $user = $request->user();
        $shoppingCart = ShoppingCart::where('user_id', $user->user_id)->first();

        $shoppingCart->cartItems()->delete();
        $shoppingCart->delete();

        return response()->json(['message' => 'Shopping cart deleted successfully.']);
    }

    private function addDefaultItemsToCart($user)
    {
        $shoppingCart = ShoppingCart::where('user_id', $user->user_id)->first();

        $products = Product::limit(20)->get();

        foreach ($products as $product) {
            $cartItem = new CartItem();
            $cartItem->cart_id = $shoppingCart->cart_id;
            $cartItem->product_id = $product->product_id;
            $cartItem->quantity = 1;
            $cartItem->save();
        }
    }
}
