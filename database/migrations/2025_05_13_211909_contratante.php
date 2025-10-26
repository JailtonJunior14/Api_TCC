
            $table->enum('type', ['empresa', 'prestador', 'contratante']);<?php

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
        Schema::create('contratante', function(Blueprint $table)
        {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nome');
            $table->string('foto')->nullable();
            $table->string('cpf')->nullable();
            $table->string('localidade');
            $table->string('uf');
            $table->string('estado');
            $table->string('cep');
            $table->string('rua');
            $table->string('numero');
            $table->string('infoadd');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratante');
    }
};
