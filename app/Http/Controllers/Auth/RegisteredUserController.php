<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SystemBootstrapService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;


class RegisteredUserController extends Controller
{
    /**
     * Instancia del servicio de arranque del sistema.
     *
     * @var \App\Services\SystemBootstrapService
     */
    protected $systemBootstrapService;

    public function __construct(SystemBootstrapService $systemBootstrapService)
    {
        $this->systemBootstrapService = $systemBootstrapService;
    }
    /**
     * Desplegar la vista de registro de usuarios.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Manejar un requisito de validación entrante para el registro de usuarios.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, SystemBootstrapService $bootstrap)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|confirmed|min:8',
            'owner_key'  => 'nullable|string',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        /**
         * Rol base obligatorio para todos los usuarios
         */
        $user->assignRole('user');

        /**
         * Si el sistema ya está inicializado → FIN
         */
        if ($bootstrap->systemIsInitialized()) {
            event(new Registered($user));
            Auth::login($user);

            return redirect()->route('home')->with('status', 'Welcome!');
        }

        /**
         * Sistema NO inicializado → validar owner
         */
        if ($bootstrap->isOwnerCandidate($validated)) {
            $user->assignRole('admin');

            $bootstrap->markSystemAsInitialized();
        }

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('home')->with('status', 'Welcome! You are now a super admin.');
    }
}
