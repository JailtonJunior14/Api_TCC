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
        Schema::create('states', function (Blueprint $table) {
            $table->integer('id_state')->primary(); // chave primária não auto-incrementável
            $table->string('state', 40)->nullable();
            $table->integer('country_id')->default(1);
            $table->tinyInteger('is_active')->default(1);
            $table->integer('sort_order')->default(9999);
            $table->string('lang', 10)->default('en');
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
