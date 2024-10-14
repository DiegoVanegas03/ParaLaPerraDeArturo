<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nombre' => 'Diego Emiliano',
                'email' => 'admin@admin.com',
                'email_verified_at' => Carbon::now(), // O puedes usar now()
                'clave' => '303943',
                'apellidoP' => 'Vanegas',
                'apellidoM' => 'Cerda',
                'rol' => 'admin',
                'password' => bcrypt('contraseña1'),
            ],
        ]);
    }
}
