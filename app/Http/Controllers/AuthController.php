<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{


    public function login()
    {
        return view('login', ['title' => 'Login']);
    }

    public function register()
    {
        return view('register', ['title' => 'Register']);
    }


    public function signUp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'role' => 'in:supplier,contractor',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }
    
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),  // Sử dụng Hash::make
            'role' => $request->role ?? 'supplier',
        ]);
    
        return response()->json(['status' => 'success', 'message' => 'Registration successful'], 201);
    }
    
    public function signIn(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
    
        // Tìm người dùng theo email
        $user = User::where('email', $email)->first();
    

        $token = JWTAuth::fromUser($user);
    

        // Trả về thông tin người dùng và token
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }
    public function me()
    {
        return response()->json(JWTAuth::user());
    }

    public function logout()
    {
        Session::flush();

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

    public function refresh()
    {
        $newToken = JWTAuth::refresh(JWTAuth::getToken());
        return $this->respondWithToken($newToken);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }

}