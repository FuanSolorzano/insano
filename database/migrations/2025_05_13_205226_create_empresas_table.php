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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('ruc')->unique(); // Identificador RUC único
            $table->string('nombre');
            $table->string('ciudad');
            $table->string('provincia');
            $table->string('direccion');
            $table->bigInteger('user_id')->unsigned(); // Clave foránea que referencia la tabla users
            $table->foreign('user_id')->references('id')->on('users'); // Define la restricción de clave foránea
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
