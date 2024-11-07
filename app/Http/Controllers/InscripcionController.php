<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\Inscripcion;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class InscripcionController extends Controller
{
    public function index(Request $request): View
    {

        $user = $request->user();
        if ($user->rol === "admin") {
            $inscripciones = Inscripcion::paginate(5);
            return view('inscripciones.index', compact('inscripciones'));
        } else {
            $grupos = Grupo::where('estado', true)->paginate(12);
            return view('inscripciones.users', compact('grupos'));
        }
    }

    public function create(): View
    {
        $inscripcion = null;
        $grupos = Grupo::all();
        $alumnos = User::select('id', 'clave', 'nombre', 'apellidoP')->where('rol', 'alumno')->get();
        foreach ($grupos as $grupo) {
            $grupo['materia'] = $grupo->materia;
            $grupo['profesor'] = $grupo->profesor;
        }
        return view('inscripciones.add-edit')->with(compact('inscripcion', 'grupos', 'alumnos'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'grupo_id' => ['required', 'exists:grupos,id'],
            'alumno_id' => ['required', 'exists:users,id'],
        ]);

        $grupo = Grupo::find($request->get('grupo_id'));
        $user = User::find($request->get('alumno_id'));
        $existingInscription = Inscripcion::where('grupo_id', $grupo->id)
            ->where('alumno_id', $user->id)
            ->first();

        if ($existingInscription) {
            return back()->with('error', 'Ya se encuentra solicitando para este grupo.');
        }

        // Verificar disponibilidad del grupo
        if ($grupo->disponible() == 0) {
            return back()->with('error', 'Error de capacidad, el grupo está lleno.');
        }

        // Crear nueva inscripción
        Inscripcion::create([
            'grupo_id' => $grupo->id,
            'alumno_id' => $user->id,
            'estado' => true,
        ]);

        return redirect()->route('inscripcion.index')->with('success', 'Inscripción realizada con éxito.');
    }
    public function solicitar(Request $request)
    {
        $request->validate([
            'grupo_id' => [
                'required',
                'exists:grupos,id',
            ],
        ]);

        $grupo = Grupo::find($request->get('grupo_id'));

        $user = $request->user();

        if ($user->rol == "admin"  || $user->rol == "profesor") {
            return back()->with('error', 'Usuario no autorizado para inscribir materias');
        }

        // Verificar si el usuario ya está inscrito en el grupo
        $existingInscription = Inscripcion::where('grupo_id', $grupo->id)
            ->where('alumno_id', $user->id)
            ->first();

        if ($existingInscription) {
            return back()->with('error', 'Ya te encuentras solicitando para este grupo.');
        }

        // Verificar disponibilidad del grupo
        if ($grupo->disponible() == 0) {
            return back()->with('error', 'Error de capacidad, el grupo está lleno.');
        }

        // Crear nueva inscripción
        Inscripcion::create([
            'grupo_id' => $grupo->id,
            'alumno_id' => $user->id,
        ]);

        return redirect()->route('inscripcion.index')->with('success', 'Inscripción realizada con éxito.');
    }

    public function edit($id): View
    {
        $inscripcion = Inscripcion::findOrFail($id);
        $grupos = Grupo::all();
        $alumnos = User::select('id', 'clave', 'nombre', 'apellidoP')->where('rol', 'alumno')->get();
        foreach ($grupos as $grupo) {
            $grupo['materia'] = $grupo->materia;
            $grupo['profesor'] = $grupo->profesor;
        }
        return view('inscripciones.add-edit')->with(compact('inscripcion', 'grupos', 'alumnos'));
    }

    public function activate($id)
    {
        $inscripcion = Inscripcion::findOrFail($id);

        $inscripcion->update([
            'estado' => true,
        ]);
        $inscripcion->save();
        return redirect()->route('inscripcion.index')->with('success', 'Se autorizo con exito la inscripción.');
    }

    public function empalme(Request $request, $id)
    {
        $grupoActual = Grupo::findOrFail($id); // Asumimos que $id es el id del grupo actual
        $inscripcionActual = Inscripcion::where('alumno_id', $request->user()->id)
            ->whereHas('grupo', function ($query) use ($grupoActual) {
                $query->where('hora_inicio', '<', $grupoActual->hora_final)
                    ->where('hora_final', '>', $grupoActual->hora_inicio);
            })
            ->first();
        $inscripcionActual->delete();
        Inscripcion::create([
            'grupo_id' => $grupoActual->id,
            'alumno_id' => $request->user()->id,
        ]);
        return redirect()->route('inscripcion.index')->with('success', 'Inscripción realizada con éxito.');
    }

    public function delete(Request $request): RedirectResponse
    {
        // Validación de la contraseña actual
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);
        $inscripcion = Inscripcion::findOrFail($request->id);
        // Eliminación del usuario
        $inscripcion->delete();
        // Redirección con mensaje de éxito
        return redirect()->route('inscripcion.index')->with('status', 'Success-delete');
    }
}
