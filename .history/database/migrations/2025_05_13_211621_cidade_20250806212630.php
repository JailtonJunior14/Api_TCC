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
        Schema::create('cities', function (Blueprint $table) {
            $table->nteger('')->primary();
            $table->string('city', 30);
            $table->integer('state_id');
            $table->tinyInteger('is_default')->default(0);
            $table->tinyInteger('is_active')->default(1);
            $table->integer('sort_order')->default(9999);
            $table->string('lang', 10)->default('en');
            $table->string('created_at', 10);
            $table->string('updated_at', 10)->nullable();

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
