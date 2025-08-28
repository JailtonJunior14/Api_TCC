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
        Schema::create('cidade', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('nome', 50);
            $table->foreign('id_estado')->references('id')->on('estado')->onDelete('cascade');

            // Opcional: se quiser criar relacionamento com a tabela states:
            // $table->foreign('state_id')->references('id_state')->on('states')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cidade');
    }
};
