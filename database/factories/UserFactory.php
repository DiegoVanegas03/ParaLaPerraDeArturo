<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->firstName,
            'apellidoP' => $this->faker->lastName,
            'apellidoM' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'clave' => $this->faker->numerify('######'),
            'rol' => 'alumno', // Valor por defecto, lo sobreescribiremos en el seeder
            'password' => bcrypt('password'), // Contraseña por defecto
        ];
    }
}
