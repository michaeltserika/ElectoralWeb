<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:utilisateurs,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'image' => ['nullable', 'image', 'max:2048'],
            'ce_number' => ['nullable', 'string', 'max:50'],
            'cin_number' => ['nullable', 'string', 'max:50'],
            'date_of_birth' => ['required', 'date', 'before:today'],
        ]);

        $imagePath = $request->file('image') ? $request->file('image')->store('utilisateurs', 'public') : null;

        $user = Utilisateur::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'mot_de_passe' => Hash::make($request->password),
            'role' => 'VOTANT',
            'image' => $imagePath,
            'ce_number' => $request->ce_number,
            'cin_number' => $request->cin_number,
            'date_of_birth' => $request->date_of_birth,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
