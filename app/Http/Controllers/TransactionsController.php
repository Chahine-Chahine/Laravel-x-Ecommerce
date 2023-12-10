<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionsController extends Controller
{
    public function create_transaction(Request $req){
        if(auth()->check()){
            $user = auth()->user();
            if($user && $user-> user_type_id == 2){
                $transaction =  Transaction::create([
                    'amount'=> $req-> amount,
                    'payment_method'=> $req-> payment_method,
                ]);

                return response()->json(['message' => 'Product added successfully']);
            }else{
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }else{
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    public function read_transaction(Request $req)
{
    if (auth()->check()) {
        $user = Auth::user();
        if ($user && $user->user_type_id == 2) {
            // Retrieve transaction_id from the request
            $transaction_id = $req->input('transaction_id');

            // Use find instead of where to get a single transaction by its ID
            $transaction = Transaction::find($transaction_id);

            if ($transaction) {
                return response()->json([
                    'Transaction' => $transaction,
                    'message' => 'Transaction displayed successfully'
                ]);
            } else {
                return response()->json(['error' => 'Transaction not found'], 404);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    } else {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
}
