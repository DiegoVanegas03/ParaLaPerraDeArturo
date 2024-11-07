<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory;

    protected $table = 'inscripciones';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'alumno_id',
        'grupo_id',
        'estado'
    ];

    public function alumno()
    {
        return $this->belongsTo(User::class, 'alumno_id');
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }

    public function obtenerCalificacion()
    {
        // Buscar la calificación basada en alumno_id y grupo_id
        $calificacion = Calificacion::where('alumno_id', $this->alumno_id)
            ->where('grupo_id', $this->grupo_id)
            ->first();

        // Si la calificación existe, devolverla; si no, devolver "Sin calificar"
        return $calificacion ? $calificacion->calificacion : "Sin calificar";
    }
}
