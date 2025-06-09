<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Rolmodel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Models\UsuarioModel;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function Login_From(): View
    {
        return view('auth.login');
    }
    public function Dashboard()
    {
        return view('dashboard');
    }
    /**
     * Handle an incoming authentication request.
     */
    public function Iniciarsesion(LoginRequest $request)
    {

        $credentials = $request->only('email', 'password');

        if (!filter_var($credentials['email'], FILTER_VALIDATE_EMAIL)) {
            return back()->withErrors(['email' => 'el formato del correo es incorrecto']);
        }
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $usuario = Auth::user();
            if ($usuario->rol_id == 1) {
                return redirect()->route('catalogo');
            }
            if ($usuario->rol_id == 2) {
                return redirect()->route('catalogo');
            }
            if ($usuario->rol_id == 3) {
                return redirect()->route('catalogo');
            }
            if (! in_array($usuario->rol_id, [1, 2, 3])) {
                return back()->withErrors(['email' => 'No tienes permisos para acceder a esta aplicación']);

            }
            # code...
        }
        return back()->withErrors(['email' => 'Correo o contraseña incorrectos']);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
