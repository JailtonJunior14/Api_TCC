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
<<<<<<< HEAD
        Schema::create('estado', function(Blueprint $table)
        {
            $table->id();
            $table->string('nome');
            $table->string('sigla', 10);
            $table->foreignId('id_pais')->constrained('pais')->onDelete('cascade');
=======
        Schema::create('states', function (Blueprint $table) {
            $table->integer('id_state')->primary(); // chave primária não auto-incrementável
            $table->string('state', 40)->nullable();
            $table->integer('country_id')->default(1);
            $table->tinyInteger('is_active')->default(1);
            $table->integer('sort_order')->default(9999);
            $table->string('lang', 10)->default('en');
>>>>>>> 216dfc3c969193680c599a728d6ae5b5c97f5477
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estado');
    }
};
