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
            $table->string('email');
            $table->string('senha');
            $table->string('foto');
            $table->string('logradouro');
            $table->string('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro');
            $table->string('cep', 9);
            $table->foreignId('id_cidade')->constrained('cidade')->onDelete('cascade');
            $table->foreignId('id_link')->constrained('link')->onDelete('cascade');
            $table->foreignId('id_portfolio')->constrained('portfolio')->onDelete('cascade');
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
