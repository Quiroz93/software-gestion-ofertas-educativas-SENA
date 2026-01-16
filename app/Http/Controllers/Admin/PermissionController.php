<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Despliega la lista de permisos.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        Gate::authorize('permissions.view'); // o middleware

        $permissions = Permission::orderBy('name')->get()
            ->groupBy(fn($p) => explode('.', $p->name)[0]);

        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Despliega el formulario para crear un nuevo permiso.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        Gate::authorize('permissions.create'); // o middleware

        $categories = Permission::all()
            ->map(fn($p) => explode('.', $p->name)[0])
            ->unique()
            ->values();

        return view('admin.permissions.create', compact('categories'));
    }

    /**
     * Almacena un nuevo permiso en la base de datos.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Gate::authorize('permissions.create'); // o middleware

        $request->validate([
            'category' => 'required|string|max:50',
            'guard_name' => 'required|string',
        ]);

        $category = strtolower($request->category);
        $guard = $request->guard_name;

        $actions = [];

        // Acciones rápidas
        if ($request->filled('quick_actions')) {
            $actions = $request->quick_actions;
        }

        // Acción principal
        if ($request->action && $request->action !== 'custom') {
            $actions[] = $request->action;
        }

        // Acción personalizada
        if ($request->action === 'custom' && $request->filled('custom_action')) {
            $actions[] = $request->custom_action;
        }

        $actions = array_unique($actions);

        foreach ($actions as $action) {
            Permission::firstOrCreate([
                'name' => $category . '.' . strtolower($action),
                'guard_name' => $guard,
            ]);
        }

        return redirect()->route('permissions.index')
            ->with('success', 'Permiso(s) creado(s) correctamente');
    }


    /**
     * Despliega el formulario para editar un permiso existente.
     *
     * @param Permission $permission
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Permission $permission)
    {
        Gate::authorize('permissions.edit'); // o middleware

        [$category, $action] = explode('.', $permission->name);

        return view('admin.permissions.edit', compact('permission', 'category', 'action'));
    }

    /**
     * Actualiza un permiso existente en la base de datos.
     *
     * @param Request $request
     * @param Permission $permission
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Permission $permission)
    {
        Gate::authorize('permissions.edit'); // o middleware

        $request->validate([
            'category' => 'required|string|max:50',
            'action' => 'required|string|max:50',
        ]);

        $permission->update([
            'name' => strtolower($request->category) . '.' . strtolower($request->action),
        ]);

        return redirect()->route('permissions.index')
            ->with('success', 'Permiso actualizado correctamente');
    }
}
