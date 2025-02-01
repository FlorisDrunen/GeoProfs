<?php

namespace app\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $validatedFields = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'rol' => 'required|in:werknemer,teammanager,officemanager'
        ]);

        $user = User::create($validatedFields);
        $token = $user->createToken($request->first_name);

        // return response()->json([
        //     'message' => __('errormessages.auth.register.success'),
        //     'user' => $user,    
        //     'token' => $token->plainTextToken
        // ], 201);
        return redirect()->route('login');
    }

    public function showLogin()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ]);
    
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'error' => __('errormessages.auth.login.failed')
            ], 401);
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            // Redirect naar dashboard
            return redirect()->route('dashboard');
        }
    
        $user = Auth::user();

        session(['user_id' => $user->id]);
        //known error but it dont do shit
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'message' => __('errormessages.auth.login.success'),
            'user' => $user,
            'token' => $token,
            'session_id' => session()->getId() 
        ]);
    }
    
    

    public function logout(Request $request)
    {
        session()->invalidate();
        session()->regenerateToken();
    
        $request->user()->tokens()->delete();
    
        // return response()->json([
        //     'message' => __('errormessages.auth.logout.success'),
        // ]);

        return redirect()->route('login');

    }
    
}
