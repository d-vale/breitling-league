<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthCreateUserValidation;
use App\Http\Requests\AuthLoginValidation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(AuthLoginValidation $request)
    {
        // Les informations de connexion
        $credentials = $request->validated();

        // Tenter de connecter l'utilisateur
        if (Auth::attempt($credentials)) {
            // Régénérer la session pour prévenir la fixation de session
            $request->session()->regenerate();

            // Rediriger vers la page d'accueil de l'application ou la page demandée
            return redirect()->intended(route('spa'));
        }

        // En cas d'échec, rediriger vers la page de connexion avec une erreur
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    public function logout()
    {
        Auth::logout();
        return response()->noContent();
    }


    public function showLogin()
    {
        return view('login');
    }
}
