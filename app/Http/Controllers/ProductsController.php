<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
   

    public function __construct(){
        $this->middleware('auth:api');
    }

    public function create_product(Request $req){
        if(auth()->check()){
            $user = auth()->user();
            if($user && $user-> user_type_id == 1){
                $product =  Product::create([
                    'product_name'=> $req-> product_name,
                    'description'=> $req-> description,
                    'price'=> $req-> price,
                    'seller_id'=> $user-> user_id,
                ]);

                return response()->json(['message' => 'Product added successfully']);
            }else{
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }else{
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    public function read_products(){
        if(auth()->check()){
            $user = Auth::user();
            if($user && $user-> user_type_id == 1){
                $seller_id = $user->user_id;
                $products = Product::where('seller_id', $seller_id)->get();
                return response()->json([
                    'products' => $products,
                    'message' => 'products desplayed successfully'
                ]);
            }else{
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }else{
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
