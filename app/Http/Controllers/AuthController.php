<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $attr = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $attr['name'],
            'password' => bcrypt($attr['password']),
            'email' => $attr['email']
        ]);

        return response()->json([
            'token' => $user->createToken('API Token')->plainTextToken
        ]);
    }

    public function login(Request $request)
    {
        // dd($request->all());
        $validate = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|min:6'
        ]);

        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()], 403);
        }

        if (!Auth::attempt($request->all())) {
            return response()->json([
                'message' => 'Credentials not match',
            ], 401);
        }

        return response()->json([
            'token' => auth()->user()->createToken('API Token')->plainTextToken
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }

    public function notAuth()
    {
        return response()->json([
            'message' => 'NoT auth user',
        ], 401);
    }
}
