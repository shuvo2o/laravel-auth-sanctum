<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
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
            "status" => 0 ,
            "message" => "Validation error",
            "data" => $validator->errors()->all()
        ]);
    }
    $user = User::create([
        "name"=> $request->name,
        "email"=> $request->email,
        "password"=> bcrypt($request->password),
    ]);
    return response()->json([
        "status" => "Register Succesfull..."
    ]);
   }
}
