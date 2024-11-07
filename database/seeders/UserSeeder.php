<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Insertar manualmente los administradores
        DB::table('users')->insert([
            [
                'nombre' => 'Diego Emiliano',
                'apellidoP' => 'Vanegas',
                'apellidoM' => 'Cerda',
                'email' => 'admin1@admin.com',
                'email_verified_at' => Carbon::now(),
                'clave' => '303943',
                'rol' => 'admin',
                'password' => bcrypt('password'),
            ],
            [
                'nombre' => 'Ana María',
                'apellidoP' => 'Gómez',
                'apellidoM' => 'Ruiz',
                'email' => 'admin2@admin.com',
                'email_verified_at' => Carbon::now(),
                'clave' => '409874',
                'rol' => 'admin',
                'password' => bcrypt('password'),
            ],
            [
                'nombre' => 'Carlos Javier',
                'apellidoP' => 'López',
                'apellidoM' => 'Mendoza',
                'email' => 'admin3@admin.com',
                'email_verified_at' => Carbon::now(),
                'clave' => '598273',
                'rol' => 'admin',
                'password' => bcrypt('password'),
            ],
        ]);

        // Generar 15 profesores
        User::factory()->count(15)->create([
            'rol' => 'profesor',
        ]);

        // Generar 200 alumnos
        User::factory()->count(200)->create([
            'rol' => 'alumno',
        ]);
    }
}
