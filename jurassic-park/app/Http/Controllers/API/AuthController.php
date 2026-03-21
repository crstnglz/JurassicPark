<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])){
            $auth = Auth::user();

            $tokenResult = $auth->createToken('LaravelSanctumAuth');

            $success = [
                'id' => $auth->id,
                'name' => $auth->name,
                'token' => $tokenResult->plainTextToken
            ];

            return response()->json([
                "success" => true,
                "data" => $success,
                "messagee" => "User logged-in!"
            ]);
        }
        else
        {
            return response()->json("Unauthorised", 204);
        }
    }
}
