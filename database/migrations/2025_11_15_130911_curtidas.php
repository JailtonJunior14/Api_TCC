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
        Schema::create('curtidas', function (Blueprint $table){
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('perfil_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->primary(['user_id', 'perfil_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curtidas');
    }
};
