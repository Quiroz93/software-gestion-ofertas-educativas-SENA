<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::orderBy('name')->get()
            ->groupBy(fn($p) => explode('.', $p->name)[0]);

        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        $categories = Permission::all()
            ->map(fn($p) => explode('.', $p->name)[0])
            ->unique()
            ->values();

        return view('admin.permissions.create', compact('categories'));
    }

    public function store(Request $request)
    {
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


    public function edit(Permission $permission)
    {
        [$category, $action] = explode('.', $permission->name);

        return view('admin.permissions.edit', compact('permission', 'category', 'action'));
    }

    public function update(Request $request, Permission $permission)
    {
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
