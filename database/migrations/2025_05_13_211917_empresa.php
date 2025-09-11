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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('cnpj')->unique();
            $table->string('razao_social');
            $table->string('foto')->nullable();
            $table->string('localidade');
            $table->string('uf');
            $table->string('estado');
            $table->string('cep');
            $table->string('numero');
            $table->string('rua');
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
