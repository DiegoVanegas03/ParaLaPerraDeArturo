<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Grupo;
use App\Models\Inscripcion;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Carbon\Carbon;



class CalificacionesController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        if ($user->rol == "admin") {
            $grupos = Grupo::all();
        } elseif ($user->rol == "profesor") {
            $grupos = Grupo::where('profesor_id', $user->id)->get();
        } else {
            $grupos = [];
        }
        foreach ($grupos as $grupo) {
            $grupo['materia'] = $grupo->materia;
            $grupo['profesor'] = $grupo->profesor;
        }
        $selectedGroup = $request->get('grupo');
        $calificaciones = null;
        if ($selectedGroup) {
            $calificaciones = Inscripcion::where('grupo_id', $selectedGroup)->paginate(10);
        } elseif ($user->rol == "alumno") {
            $calificaciones = Calificacion::where('alumno_id', $user->id)->get();
            return view('calificaciones.alumnos')->with(compact('calificaciones'));
        }
        return view('calificaciones.index')->with(compact('calificaciones', 'grupos', 'selectedGroup'));
    }

    public function register(Request $request, $id)
    {

        if ($request->get('calificacion') < 0 || $request->get('calificacion') > 10) {
            return back()->with('error', 'Calificacion Invalida');
        }


        $inscripcion = Inscripcion::findOrFail($id);
        $queryCalificacion = Calificacion::where('alumno_id', $inscripcion->alumno_id)->where('grupo_id', $inscripcion->grupo_id);
        if ($queryCalificacion->exists()) {
            $calificacion = $queryCalificacion->first();
            $calificacion->update([
                'calificacion' => $request->get('calificacion')
            ]);
        } else {
            Calificacion::create([
                'alumno_id' => $inscripcion->alumno_id,
                'grupo_id' => $inscripcion->grupo_id,
                'calificacion' => $request->get('calificacion')
            ]);
        }
        return redirect()->back();
    }
}
