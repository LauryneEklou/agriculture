<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function show()
    {
        return view('Login');
    }

    public function login(Request $request)
    {
        // Validation des données
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:12',
                'regex:/^(?=.*[A-Z])(?=.*[\W_]).{8,12}$/'
            ],
        ], [
            'password.regex' => 'Le mot de passe doit contenir au moins une lettre majuscule, un caractère spécial et être entre 8 et 12 caractères.',
        ]);

        // Vérifier si l'utilisateur veut être "retenu" après la fermeture du navigateur
        $remember = $request->has('remember');

        // Tentative d'authentification avec "remember"
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();  

            if (Auth::user()->role === 'admin') {
                return redirect()->route('dashboard')->with('success', 'Admin Connecté avec succcès');
            } else {
                return redirect()->route('transactions.index')->with('success', 'Utilisateur connecté avec succès');
            }
        }

        // Vérification de l'existence de l'utilisateur
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Utilisateur trouvé, mais mauvais mot de passe
            return back()->withErrors([
                'password' => 'Le mot de passe que vous avez entré est incorrect.',
            ])->withInput($request->only('email'));
        } else {
            // Email inexistant
            return back()->withErrors([
                'email' => 'Aucun compte trouvé avec cet email.',
            ]);
        }
    }
    public function showRegisterForm()
    {
        return view('register');  
    }
    public function register(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'max:12',
                'regex:/^(?=.*[A-Z])(?=.*[\W_]).{8,12}$/',
            ],
        ], [
            'password.regex' => 'Le mot de passe doit contenir au moins une lettre majuscule, un caractère spécial et être entre 8 et 12 caractères.',
        ]);
    
        // Création de l'utilisateur
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']), // Hachage du mot de passe
        ]);
        
        // Redirection ou réponse JSON
        return redirect()->route('login')->with('message', 'Inscription réussie, vous pouvez vous connecter.');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
