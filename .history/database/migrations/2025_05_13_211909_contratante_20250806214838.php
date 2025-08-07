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
        Schema::create('contratante', function(Blueprint $table)
        {
            $table->id();
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('foto')->nullable();
            $table->integer('id_cidade');
            $table->foreign('id_cidade')->references('id_city')->on('cities')->onDelete('cascade');
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
