<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        //Validamos la solicitud de restablecimiento de contraseña. En este caso, solo necesitamos validar el campo de correo electrónico.
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        //Enviaremos el enlace de restablecimiento de contraseña a este usuario. Una vez que hayamos intentado enviar el enlace, examinaremos la respuesta y veremos el mensaje que debemos mostrarle. Finalmente, enviaremos la respuesta correcta.
        $status = Password::sendResetLink( // Enviamos el enlace de restablecimiento de contraseña
            $request->only('email') // Solo necesitamos el correo electrónico
        );
        dump("estado: ".$status);
        if ($status == Password::RESET_LINK_SENT) { // 
            return back()->with('status', __($status)); // Si el enlace se envió correctamente, redirigimos al usuario a la página anterior con un mensaje de éxito
        }
        else {
            return back()->withInput($request->only('email')) // Si hubo un error, redirigimos al usuario a la página anterior con un mensaje de error
                ->withErrors(['email' => __($status)]);
        }
        

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
