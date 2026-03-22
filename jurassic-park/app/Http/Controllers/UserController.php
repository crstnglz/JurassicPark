<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //GET ALL USERS
    public function index()
    {
        if(auth()->user()->role !== 'admin')
        {
            return response()->json(["error" => "Forbidden"], 403);
        }

        return response()->json(User::all(), 200);
    }

    //CREATE USER
    public function store(Request $request)
    {
        if(auth()->user()->role !== 'admin')
        {
            return response()->json(["error" => "Forbidden"], 403);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role
        ]);

        return response()->json($user, 201);
    }

    //DELETE USER
    public function destroy($id)
    {
        if(auth()->user()->role !== 'admin')
        {
            return response()->json(["error" => "Forbidden"], 403);
        }

        $user = User::find($id);

        if(!$user)
        {
            return response()->json(["error" => "User not found"], 404);
        }

        $user->delete();

        return response()->json(["message" => "User deleted"]);
    }

    //UPDATE USER
    public function update($id, Request $request)
    {
        if(auth()->user()->role !== 'admin')
        {
            return response()->json(["error" => "Forbidden"], 403);
        }

        $user = User::find($id);

        if(!$user)
        {
            return response()->json(["error" => "User not found"], 404);
        }

        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        $user->role = $request->role ?? $user->role;

        if($request->password)
        {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return response()->json([
            "success" => true,
            "user" => $user
        ]);
    }

    public function count()
    {
        return response()->json(['total' => \App\Models\User::count()]);
    }
}
