<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LogInRequest;
use App\Http\Requests\SignUpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), (new SignUpRequest())->rules());

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            "message" => "success"
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), (new LogInRequest())->rules());

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $accessToken = $user->createToken('API Token')->accessToken;

            return response()->json([
                "message" => "success",
                "token" => $accessToken
            ]);
        }

        return response()->json([
            'message' => 'Invalid credentials.',
        ]);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();

        // Revoke the access token
        $token->revoke();

        return response()->json([
            "message" => "success"
        ]);
    }
}
