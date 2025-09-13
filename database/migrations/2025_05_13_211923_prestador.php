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
        Schema::create('prestador', function(Blueprint $table)
        {
            $table->id();
            $table->string('nome');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('cpf');
            $table->string('foto')->nullable();
            $table->string('localidade');
            $table->string('uf');
            $table->string('estado');
            $table->string('cep');
            $table->string('numero');
            $table->string('rua');
            $table->string('infoadd');
            $table->foreignId('id_ramo')->constrained('ramo')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestador');
    }
};
