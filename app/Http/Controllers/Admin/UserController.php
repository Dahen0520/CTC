<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'roles' => 'nullable|array'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->syncRoles($validated['roles'] ?? []);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado exitosamente.');
    }


    public function edit(User $user)
    {
        if ($user->email === 'admin@dahen.dev') {
            abort(403, 'ESTE USUARIO NO PUEDE SER EDITADO.');
        }

        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }


    public function update(Request $request, User $user)
    {
        if ($user->email === 'admin@dahen.dev') {
            abort(403, 'ESTE USUARIO NO PUEDE SER EDITADO.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'roles' => 'nullable|array'
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $user->syncRoles($validated['roles'] ?? []);

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado exitosamente.');
    }


    public function destroy(User $user)
    {
        if ($user->email === 'admin@dahen.dev') {
            return back()->with('error', 'El usuario Administrador principal no puede ser eliminado.');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar a tu propio usuario.');
        }

        $user->delete();

        return back()->with('success', 'Usuario eliminado exitosamente.');
    }
}