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
        Schema::create('empresa', function(Blueprint $table)
        {
            $table->id();
            $table->string('nome');
            $table->string('email');
            $table->string('senha');
            $table->string('whatsapp');
            $table->string('fixo');
            $table->string('foto');
            $table->string('cnpj', 18)->unique();
            $table->string('cep', 9);
            $table->foreignId('id_cidade')->constrained('cidade')->onDelete('cascade');
            $table->foreignId('id_ramo')->constrained('ramo')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresa');
    }
};
