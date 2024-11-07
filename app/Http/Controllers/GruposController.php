<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\Materia;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;


class GruposController extends Controller
{
    public function index(Request $request): View
    {
        if ($request->user()->rol === "admin") {
            $search = $request->get("search");
            if ($search) {
                $columnas = json_decode($request->get('columnas'), true);
                $searchAnidado = [
                    'profesor' => ['nombre', 'apellidoP', 'apellidoM'],
                    'materia' => ['nombre']
                ];
                $grupos = Grupo::join('users', 'grupos.profesor_id', '=', 'users.id')
                    ->join('materias', 'grupos.materia_id', '=', 'materias.id')
                    ->where(function ($query) use ($search) {
                        $query->where('users.nombre', 'LIKE', "%$search%")
                            ->orWhere('users.apellidoP', 'LIKE', "%$search%")
                            ->orWhere('users.apellidoM', 'LIKE', "%$search%")
                            ->orWhere('materias.nombre', 'LIKE', "%$search%");
                    })
                    ->select('grupos.*') // Selecciona solo las columnas de `grupos`
                    ->get();
            } else {
                $grupos = Grupo::paginate(10);
            }
            return view('grupos.index', compact('grupos'));
        } else {
            $gruposSinAutorizar  = Grupo::where('profesor_id', $request->user()->id)->where('estado', false)->get();
            $gruposAutorizados  = Grupo::where('profesor_id', $request->user()->id)->where('estado', true)->get();
            $materias = Materia::all();
            return view('grupos.profesores', compact('gruposSinAutorizar', 'gruposAutorizados', 'materias'));
        }
    }

    public function addMaterias(): View
    {
        $grupo = null;
        $materias = Materia::all();
        $profesores = User::select('id', 'clave', 'nombre', 'apellidoP')->where('rol', 'profesor')->get();
        return view('grupos.add-edit', compact('grupo', 'materias', 'profesores'));
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'materia_id' => ['required', 'exists:materias,id'],
            'profesor_id' => [
                'required',
                Rule::exists('users', 'id')->where('rol', 'profesor')
            ],
            'hora_inicio' => ['required', 'date_format:H:i'], // Cambia 'time' a 'date_format:H:i' para validar un formato de hora
            'hora_final' => ['required', 'date_format:H:i'],
        ]);
        if ($request->user()->rol === "admin") {
            $estado = true;
        } else {
            $estado = false;
        }
        Grupo::create([
            'materia_id' => $request->materia_id,
            'profesor_id' => $request->profesor_id,
            'hora_inicio' => $request->hora_inicio,
            'hora_final' => $request->hora_final,
            'estado' => $estado,
        ]);
        return redirect(route('grupos.index', absolute: false))->with('status', 'grupo-created');
    }

    public function activate($id): RedirectResponse
    {
        $grupo = Grupo::findOrFail($id);
        $grupo->estado = true;
        $grupo->save();
        return redirect(route('grupos.index', absolute: false))->with('status', 'grupo-activated');
    }

    public function edit($id): View
    {
        $grupo = Grupo::findOrFail($id);
        $materias = Materia::all();
        $profesores = User::select('id', 'clave', 'nombre', 'apellidoP')->where('rol', 'profesor')->get();
        return view('grupos.add-edit')->with(compact('grupo', 'materias', 'profesores'));
    }

    public function update(Request $request): RedirectResponse
    {
        // Asegúrate de validar el ID que siempre debe estar presente
        $request->validate(['id' => ['required']]);
        // Encuentra al usuario por ID
        $grupos = Grupo::findOrFail($request->id);
        // Define las reglas de validación
        $columns = [
            'materia_id' => ['required', 'exists:materias,id'],
            'profesor_id' => [
                'required',
                Rule::exists('users', 'id')->where('rol', 'profesor')
            ],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_final' => ['required', 'date_format:H:i'],
        ];
        // Crear un arreglo para las reglas de validación a aplicar
        $rules = [];
        // Recorre cada columna para verificar si ha cambiado
        foreach ($columns as $column => $validationRules) {
            // Verifica si el valor ha cambiado
            if ($request[$column] !== (string)$grupos[$column]) {
                $rules[$column] = $validationRules;
            }
        }
        $request->validate($rules);
        // Actualiza el usuario con los nuevos valores
        $grupos->update($request->only(array_keys($rules)));
        return redirect()->route('grupos.index')->with('status', 'Success-update');
    }

    public function delete(Request $request): RedirectResponse
    {
        // Validación de la contraseña actual
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);
        $grupo = Grupo::findOrFail($request->id);
        // Eliminación del usuario
        $grupo->delete();
        // Redirección con mensaje de éxito
        return redirect()->route('grupos.index')->with('status', 'Success-delete');
    }
}
