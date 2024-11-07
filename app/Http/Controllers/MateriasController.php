<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;



class MateriasController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->get("search");
        if ($search) {
            $columnas = json_decode($request->get('columnas'), true);
            $materias = Materia::where(function ($q) use ($search, $columnas) {
                foreach ($columnas as $column) {
                    $q->orWhere($column, 'LIKE', "%$search%");
                }
            })->get();
        } else {
            $materias = Materia::paginate(10);
        }
        return view('materias.index', compact('materias'));
    }

    public function addMaterias(): View
    {
        $materia = null;
        return view('materias.add-edit', compact('materia'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'clave' => ['required', 'integer', 'max:2147483647'],
            'nombre' => ['required', 'string', 'max:255'],
            'creditos' => ['required', 'integer', 'max:2147483647'],
        ]);
        Materia::create([
            'clave' => $request->clave,
            'nombre' => $request->nombre,
            'creditos' => $request->creditos,
        ]);
        return redirect(route('materias.index', absolute: false))->with('status', 'user-created');
    }

    public function edit($id): View
    {
        $materia = Materia::findOrFail($id);
        return view('materias.add-edit')->with(compact('materia'));
    }

    public function update(Request $request): RedirectResponse
    {
        // Asegúrate de validar el ID que siempre debe estar presente
        $request->validate(['id' => ['required']]);
        // Encuentra al usuario por ID
        $materia = Materia::findOrFail($request->id);
        // Define las reglas de validación
        $columns = [
            'clave' => ['required', 'integer', 'max:2147483647'],
            'nombre' => ['required', 'string', 'max:255'],
            'creditos' => ['required', 'integer', 'max:2147483647'],
        ];
        // Crear un arreglo para las reglas de validación a aplicar
        $rules = [];
        // Recorre cada columna para verificar si ha cambiado
        foreach ($columns as $column => $validationRules) {
            // Verifica si el valor ha cambiado
            if ($request[$column] !== (string)$materia[$column]) {
                $rules[$column] = $validationRules;
            }
        }
        $request->validate($rules);
        // Actualiza el usuario con los nuevos valores
        $materia->update($request->only(array_keys($rules)));
        return redirect()->route('materias.index')->with('status', 'Success-update');
    }

    public function delete(Request $request): RedirectResponse
    {
        // Validación de la contraseña actual
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);
        $materia = Materia::findOrFail($request->id);
        // Eliminación del usuario
        $materia->delete();
        // Redirección con mensaje de éxito
        return redirect()->route('materias.index')->with('status', 'Success-delete');
    }
}
