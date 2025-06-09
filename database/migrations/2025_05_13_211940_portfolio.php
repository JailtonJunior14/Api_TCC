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
        Schema::create('portfolio', function(Blueprint $table)
        {
            $table->id();
            $table->string('descricao');
            $table->string('imagem');
            $table->foreignId('id_prestador')->constrained('prestador')->onDelete('cascade');
            $table->foreignId('id_empresa')->constrained('empresa')->onDelete('cascade');

        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio');
    }
};
