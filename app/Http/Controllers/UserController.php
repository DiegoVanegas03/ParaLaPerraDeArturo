<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->get("search");
        if ($search) {
            $columnas = json_decode($request->get('columnas'), true);
            $users = User::where(function ($q) use ($search, $columnas) {
                foreach ($columnas as $column) {
                    $q->orWhere($column, 'LIKE', "%$search%");
                }
            })->get();
        } else {
            $users = User::paginate(10);
        }

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        $user = null;
        return view('users.add-edit')->with(compact('user'));
    }

    public function edit($id): View
    {
        $user = User::findOrFail($id);
        return view('users.add-edit')->with(compact('user'));
    }

    public function update(Request $request): RedirectResponse
    {
        // Asegúrate de validar el ID que siempre debe estar presente
        $request->validate(['id' => ['required']]);
        // Encuentra al usuario por ID
        $user = User::findOrFail($request->id);
        // Define las reglas de validación
        $columns = [
            'clave' => ['required', 'integer', 'max:2147483647'],
            'nombre' => ['required', 'string', 'max:255'],
            'apellidoP' => ['required', 'string', 'max:255'],
            'apellidoM' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'rol' => ['required', 'string', 'max:8'],
        ];
        // Crear un arreglo para las reglas de validación a aplicar
        $rules = [];
        // Recorre cada columna para verificar si ha cambiado
        foreach ($columns as $column => $validationRules) {
            // Verifica si el valor ha cambiado
            if ($request[$column] !== (string)$user[$column]) {
                $rules[$column] = $validationRules;
            }
        }
        // Si hay cambios en el email, asegúrate de que sea único
        if (isset($rules['email'])) {
            $rules['email'][] = 'unique:users,email,' . $user->id; // Excluye el email actual
        }
        // Valida los datos de la solicitud solo para los campos modificados
        $request->validate($rules);
        // Actualiza el usuario con los nuevos valores
        $user->update($request->only(array_keys($rules)));
        return redirect()->route('users.index')->with('status', 'Success-update');
    }


    public function delete(Request $request): RedirectResponse
    {
        // Validación de la contraseña actual
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);
        $user = User::findOrFail($request->id);
        // Eliminación del usuario
        $user->delete();

        // Redirección con mensaje de éxito
        return redirect()->route('users.index')->with('status', 'Success-delete');
    }
}
