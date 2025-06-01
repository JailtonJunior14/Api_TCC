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
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->foreignId('id_prestador_destino')->nullable();
            $table->foreignId('id_empresa_autor')->nullable();
            $table->foreignId('id_contratante_autor')->nullable();
            $table->foreignId('id_empresa_destino')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
