<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class grupo extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'materia_id',
        'profesor_id',
        'capacidad',
        'hora_inicio',
        'hora_final',
        'estado',
    ];

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    // Relación con la tabla 'users' para el profesor
    public function profesor()
    {
        return $this->belongsTo(User::class, 'profesor_id');
    }

    // Relación con inscripciones
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }

    // Función para contar el número de inscripciones
    public function disponible()
    {
        return $this->capacidad - $this->inscripciones()->count();
    }

    public function estadoAlumno()
    {
        $user = Auth::user();
        // Verificar si el usuario tiene una inscripción en este grupo

        $inscrito = $this->inscripciones()->where('alumno_id', $user->id);
        if ($inscrito->exists()) {
            if ($inscrito->first()->estado) return "autorizado";
            return "solicitada";
        }

        // Verificar si el grupo está lleno
        if ($this->disponible()  == 0) {
            return "lleno";
        }

        // Verificar si el usuario está inscrito en otro grupo a la misma hora
        $empalme = self::whereHas('inscripciones', function ($query) use ($user) {
            $query->where('alumno_id', $user->id);
        })
            ->where('hora_inicio', '<', $this->hora_final)
            ->where('hora_final', '>', $this->hora_inicio)
            ->exists();

        if ($empalme) {
            return "empalme";
        }
        return "inscribirse";
    }
}
