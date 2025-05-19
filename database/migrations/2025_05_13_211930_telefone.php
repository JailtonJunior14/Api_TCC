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
        Schema::create('telefone', function(Blueprint $table)
        {
            $table->id();
            $table->string('numero');
            $table->unsignedBigInteger('telefoneable_id');
            $table->string('telefoneable_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telefone');
    }
};
