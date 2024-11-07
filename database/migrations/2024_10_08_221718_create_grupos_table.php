<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materia_id')->constrained('materias')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('profesor_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('capacidad')->default(30);
            $table->time('hora_inicio');
            $table->time('hora_final');
            $table->boolean('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupos');
    }
};
