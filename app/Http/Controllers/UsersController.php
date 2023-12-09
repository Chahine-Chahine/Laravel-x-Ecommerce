<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
    public $timestamps = false;

    public function create_user(Request $req)
    {
       
        $req->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'user_type_id' => 'required|integer',
        ]);

   
        $hashedPassword = Hash::make($req->password);

  
        $user = User::create([
            'username' => $req->username,
            'email' => $req->email,
            'password' => $hashedPassword,
            'user_type_id' => $req->user_type_id,
        ]);

        return response()->json(['message' => 'User added successfully'], 201);
    }
}
