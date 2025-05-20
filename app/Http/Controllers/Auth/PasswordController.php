<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        dump($request->all());
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'], // Validación de la nueva contraseña
        ]);

        $request->user()->update([ // Actualiza el usuario autenticado
            'password' => Hash::make($validated['password']), // Encriptar la nueva contraseña
            'remember_token' =>  Str::random(60), // Optional: Update remember token

        ]);


        return back()->with('status', 'password-updated');
    }
}
