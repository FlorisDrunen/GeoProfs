<?php

namespace app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use app\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedFields = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8'
        ]);

        $user = User::create($validatedFields);
        $token = $user->createToken($request->first_name);

        return response()->json([
            'message' => 'User created successfully!',
            'user' => $user,
            'token' => $token->plainTextToken
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|email|exists:users',
            'password'=>'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response()->json([
                'error'=>'A user with the provided email address could not be found.',
                'provided email'=>$request->email
            ], 401);
        }

        if(!Hash::check($request->password, $user->password)){
            return response()->json([
                'error'=>'The provided password is incorrect.'
            ], 401);
        }

        $token = $user->createToken($user->first_name);

        return response()->json([
            'message'=>'Login successfull',
            'user'=>$user,
            'token'=>$token->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message'=>'Logout successfull!'
        ]);
    }
}
