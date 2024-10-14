<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
