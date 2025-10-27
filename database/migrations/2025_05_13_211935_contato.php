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
        Schema::create('contatos', function(Blueprint $table)
        {
            $table->id();
            $table->string('whatsapp')->nullable();
            $table->string('telefone')->nullable();
            $table->string('site')->nullable();
            $table->string('instagram')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');


        }
    );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contatos');
    }
};
