<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => 0,
                "message" => "Validation error",
                "data" => $validator->errors()->all()
            ]);
        }
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
        ]);
        $response = [];
        $response['token'] = $user->createToken("MyApp")->plainTextToken;
        $response['name'] = $user->name;
        $response['email'] = $user->email;
        return response()->json([
            "status" => 1,
            "message" => "Register Successful",
            "data" => $response
        ]);
    }

    
    public function login(Request $request)
    {
        if (Auth::attempt(["email" => $request->email, "password" => $request->password])) {
            $user = Auth::user();
            $response = [];
              $response['token'] = $user->createToken("MyApp")->plainTextToken;
            $response['name'] = $user->name;
            $response['email'] = $user->email;
            return response()->json([
                "status" => 1,
                "message" => "Login Successful",
                "data" => $response
            ]);
        } else {
            return response()->json([
                "status" => 0,
                "message" => "Authentication Failed",
                "data" => null
            ]);
        }
    }
}
