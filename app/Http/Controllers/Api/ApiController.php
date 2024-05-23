<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiController extends Controller
{
    // Add admin User API (POST, form-data)
    public function createNewUser(Request $request)
    {

        // Data validation
        $request->validate([
            "fname" => "required",
            "lname" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|confirmed",
            "role" => "required"

        ]);

        // Data save
        User::create([
            "fname" => $request->fname,
            "lname" => $request->lname,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "role" => $request->role
        ]);

        // Response
        return response()->json([
            "status" => true,
            "message" => "Admin User Created successfully"
        ]);
    }

    // Login API (POST, form-data)
    public function login(Request $request)
    {
        // Data validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        // JWTAuth and attempt

        $token = JWTAuth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ]);

        //Response

        if (!empty($token)) {

            return response()->json([
                "status" => true,
                "message" => "User logged in successfully",
                "token" => $token
            ]);
        }

        return response()->json([
            "status" => false,
            "message" => "Invalid Login details"
        ]);
    }

    // Profile API (get)
    public function profile()
    {
        $userData = auth()->user();

        return response()->json([
            "status" => true,
            "message" => "Profile data",
            "user" => $userData
        ]);
    }

    // Refresh token API (get)
    public function refreshToken()
    {
        $newToken = auth()->refresh();

        return response()->json([
            "status" => true,
            "message" => "New Access Token Generated",
            "token" => $newToken
        ]);
    }

    // Logout API (get)
    public function logout()
    {
        auth()->logout();

        return response()->json([
            "status" => true,
            "message" => "User logged out successfully"
        ]);
    }
}
