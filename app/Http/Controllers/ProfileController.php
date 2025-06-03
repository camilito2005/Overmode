<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Rolmodel;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function showProfileForm(): View
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }
    public function edit(Request $request): View
    {
        $ciudad = [
            'Bogotá', 'Medellín', 'Cali', 'Barranquilla', 'Cartagena',
            
        ];
        $roles = Rolmodel::all();
        return view('profile.edit', [
            'user' => $request->user(),
        ], compact('ciudad', 'roles')); // Pasar los roles a la vista
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated()); // validated() devuelve un array con los datos validados
        $request->user()->nombre = $request->name; // Asignar el nombre
        $request->user()->apellido = $request->apellidos; // Asignar el apellido
        $request->user()->direccion = $request->direccion; // Asignar la dirección
        $request->user()->telefono = $request->telefono; // Asignar el teléfono
        $request->user()->ciudad = $request->ciudad; // Asignar la ciudad
        $request->user()->rol_id = $request->cargo; // Asignar el rol


        if ($request->user()->isDirty('email')) {// isDirty() verifica si el campo ha cambiado
            $request->user()->email = $request->email;// Si el email ha cambiado, se establece como no verificado

        }

        $request->user()->save(); // Guardar los cambios en el usuario

        return Redirect::route('profile.edit')->with('status', 'perfil actulizado'); // Redirigir a la vista de perfil con un mensaje de éxito
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
