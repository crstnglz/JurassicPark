<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

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
                'role' => $auth->role,
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

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,veterinario,mantenimiento'
        ]);

        if($validator->fails())
        {
            return response()->json([
                "success" => false,
                "errors" => $validator->errors()
            ], 422);
        }

        if($request->role === 'admin')
        {
            return response()->json([
                "success" => false,
                "message" => "No puedes registrate como admin"
            ], 403);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role
        ]);

        $token = $user->createToken('LaravelSanctumAuth')->plainTextToken;

        return response()->json([
            "success" => true,
            "data" => [
                "id" => $user->id,
                "name" => $user->name,
                "token" => $token
            ],
            "message" => "User registered!"
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "success" => true,
            "message" => "Logged out"
        ]);
    }
}
