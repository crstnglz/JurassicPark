<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
                'image' => $auth->image,
                'token' => $tokenResult->plainTextToken
            ];

            return response()->json([
                "success" => true,
                "data" => $success,
                "message" => "User logged-in!"
            ]);
        }
        else
        {
            return response()->json([
                "success" => false,
                "message" => "Unauthorised"
            ], 401);
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
                "message" => "No puedes registrarte como admin"
            ], 403);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'image' => null
        ]);

        $token = $user->createToken('LaravelSanctumAuth')->plainTextToken;

        return response()->json([
            "success" => true,
            "data" => [
                "id" => $user->id,
                "name" => $user->name,
                "role" => $user->role,
                "image" => $user->image,
                "token" => $token
            ],
            "message" => "User registered!"
        ]);
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'La contraseña actual es obligatoria',
            'new_password.required' => 'La nueva contraseña es obligatoria',
            'new_password.min' => 'La nueva contraseña debe tener al menos 8 caracteres',
            'new_password.confirmed' => 'Las contraseñas no coinciden'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $user = auth()->user();

        if(!Hash::check($request->current_password, $user->password))
        {
            return response()->json([
                'success' => false,
                'message' => 'La contraseña actual no es correcta'
            ], 401);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Contraseña actualizada correctamente'
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
