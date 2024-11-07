<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Grupo;
use App\Models\User;
use App\Models\Materia;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Grupo>
 */
class GrupoFactory extends Factory
{
    protected $model = Grupo::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Obtener un usuario que tenga el rol de 'profesor'
        $profesorId = User::where('rol', 'profesor')->inRandomOrder()->first()->id;

        // Obtener un ID de una materia existente
        $materiaId = Materia::inRandomOrder()->first()->id;

        // Generar horas de inicio y fin
        $horaInicio = Carbon::createFromTime($this->faker->numberBetween(8, 15), 0, 0);
        $duracion = $this->faker->numberBetween(1, 2); // Duración entre 1 y 2 horas
        $horaFinal = (clone $horaInicio)->addHours($duracion);

        return [
            'profesor_id' => $profesorId,
            'materia_id' => $materiaId,
            'estado' => $this->faker->boolean(50),
            'hora_inicio' => $horaInicio->format('H:i:s'),
            'hora_final' => $horaFinal->format('H:i:s'),
        ];
    }
}
