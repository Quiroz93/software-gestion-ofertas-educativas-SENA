<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | este controlador maneja la autenticación de usuarios para la aplicación y
    | redirige a los usuarios a su pantalla de inicio después de iniciar sesión. El controlador utiliza un
    | rasgo para proporcionar su funcionalidad de inicio de sesión.
    */

    use AuthenticatesUsers;

    /**
     * después de iniciar sesión, a dónde redirigir a los usuarios.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Crear una nueva instancia del controlador.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('coordinador')) {
            return redirect()->route('coordinador.dashboard');
        }

        return redirect()->route('dashboard');
    }
}
