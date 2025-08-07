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
         Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('country_name', 20);
            $table->string('country_code', 2);
            $table->string('dial_code', 5);
            $table->string('currency_name', 20);
            $table->string('currency_symbol', 20)->charset('utf8')->collation('utf8_unicode_ci');
            $table->string('currency_code', 10);
            $table->longText('country_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
