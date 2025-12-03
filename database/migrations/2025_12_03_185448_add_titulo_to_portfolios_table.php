<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTituloToPortfoliosTable extends Migration
{
    public function up()
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->string('titulo', 255)->nullable()->after('id');
        });
    }

    public function down()
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn('titulo');
        });
    }
}