<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Materia;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MateriaFactory extends Factory
{
    protected $model = Materia::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'clave' => $this->faker->unique()->numerify('######'), // Clave única de materia
            'nombre' => $this->faker->words(2, true),               // Nombre de la materia
            'creditos' => $this->faker->numberBetween(1, 10),       // Créditos entre 1 y 10
            'created_at' => now(),                                  // Timestamp de creación actual
            'updated_at' => now(),                                  // Timestamp de última actualización actual
        ];
    }
}
