<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grupo;


class GrupoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Grupo::factory()->count(20)->create();
    }
}
