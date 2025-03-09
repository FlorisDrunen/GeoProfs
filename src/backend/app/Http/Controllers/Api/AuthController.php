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
    // hier wordt de register knop gelaten zien als je een officemanager bent
    public function showRegister()
    {
        if (Auth::user() && Auth::user()->rol !== 'officemanager') {
            return redirect()->route('dashboard')->withErrors(['error' => 'Je hebt geen toegang tot deze pagina.']);
        }
        return view('auth.register');
    }
    // hier mag je iemand registreren als je een officemanager bent
    public function register(Request $request)
    {
        if (Auth::user() && Auth::user()->rol !== 'officemanager') {
            return redirect()->route('dashboard')->withErrors(['error' => 'Je hebt geen toegang tot deze actie.']);
        }
        // dit zijn de velden waar je het account kan maken
        $validatedFields = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'rol' => 'required|in:werknemer,teammanager'
        ]);

        $user = User::create($validatedFields);
        $token = $user->createToken($request->first_name);

        // return response()->json([
        //     'message' => __('errormessages.auth.register.success'),
        //     'user' => $user,    
        //     'token' => $token->plainTextToken
        // ], 201);
        return redirect()->route('dashboard');
    }
    // hier word de login view gelaten zien zodat je kan inloggen
    public function showLogin()
    {
        return view('auth.login');
    }
    // hier word je login poging geregistereed en gecontroleerd of je een account hebt
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
 
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'message' => __('errormessages.auth.login.success'),
            'user' => $user,
            'token' => $token,
            'session_id' => session()->getId() 
        ]);
    }
    
    
    // hier word de sessie beeindicht als je uitlogd
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
