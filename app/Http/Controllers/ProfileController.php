<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Controlador para la gestión del perfil de usuario
 * 
 * Esta clase maneja las operaciones relacionadas con la visualización
 * y actualización del perfil del usuario autenticado
 * 
 * @package App\Http\Controllers
 */
class ProfileController extends Controller
{
    /**
     * Muestra el formulario de edición del perfil
     * 
     * @return View Vista con el formulario de edición del perfil
     */
    public function edit(): View
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Actualiza los datos del perfil del usuario
     * 
     * @param Request $request Objeto con los datos de la petición HTTP
     * @return RedirectResponse Redirección con mensaje de éxito o error
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
        ]);

        if ($user = Auth::user()) {
            $user->update($request->only('name', 'email'));
        }

        return redirect()->route('profile.edit')->with('success', 'Perfil actualizado exitosamente.');
    }

    /**
     * Actualiza la contraseña del usuario
     * 
     * @param Request $request Objeto con los datos de la petición HTTP
     * @return RedirectResponse Redirección con mensaje de éxito o error
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('profile.edit')->with('success', 'Contraseña actualizada exitosamente.');
    }
}