<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Rolmodel;
use App\Models\UsuarioModel;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $roles = Rolmodel::all();
        $ciudades = ['Bogotá', 'Medellín', 'Cali', 'Barranquilla', 'Cartagena'];
        return view('auth.register', compact('roles', 'ciudades')); // Pasar los roles a la vista
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        dump($request->all());
        // Validar los datos de entrada
        $validacion = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'direccion' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:15'],
            'ciudad' => ['required', 'string', 'max:255'],
            'cargo' => ['required', 'exists:'.Rolmodel::class.',id'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.UsuarioModel::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]); // Validar los datos de entrada

        if (!$validacion) {
            return back()->withErrors($validacion)->withInput(); // Redirigir de vuelta con errores de validación
            # code...
        }

        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return back()->withErrors(['email' => 'el formato del correo es incorrecto']);
        } // Validar el formato del correo electrónico
        if (UsuarioModel::where('email', $request->email)->exists()) {
            return back()->withErrors(['email' => 'El correo ya está registrado']);
        }// Verificar si el correo ya está registrado

        $user = UsuarioModel::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'password' => Hash::make($request->password),
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'ciudad' => $request->ciudad,
            'email' => $request->email,
            'rol_id' => $request->cargo,
        ]); // Crear el usuario en la base de datos
        if (!$user) { // Verificar si el usuario se creó correctamente
            return back()->withErrors(['email' => 'Error al registrar el usuario']);
            # code...
        }


        event(new Registered($user)); // Disparar el evento de registro

        Auth::login($user);// Iniciar sesión automáticamente al usuario registrado

        return redirect(route('login', absolute: false));// Redirigir al usuario a la página de inicio después del registro
    }
}
