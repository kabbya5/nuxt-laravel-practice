<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user = User::first();

        $token = $user->createToken('authToken')->accessToken;

        $response = response()->json([
            'user' => $user,
        ]);

        $cookie = cookie('auth_token', $token, 60*24, null, null, true, true); // 1 day, secure, httpOnly
        
        return $response->withCookie($cookie);
    }

    public function login(Request $request){
        $data = $request->validate([
            'emial' => "required|email",
            'password' => 'required',
        ]);

        $user = User::where('email', $data['email'])->first();

        if(!$user || !Hash::check($data['password'], $user->password)){
            return response()->json(['message' => 'Invalid Credentials']);
        }

        $token = $user->createToken('atuhToken')->accessToken;

        $response = response()->json([
            'user' => $user,
        ]);

        $cookie = cookie('auth_token', $token, 60*24, null, null, true, true); // 1 day, secure, httpOnly
        return $response->withCookie($cookie);
    }

    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->tokens()->delete();
        }

        return response()->json([
            'message' => 'Logged out successfully'
        ])->withCookie(cookie()->forget('auth_token'));
    }


}
