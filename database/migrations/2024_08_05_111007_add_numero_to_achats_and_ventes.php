<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('achats', function (Blueprint $table) {
            $table->string('numero_achat')->unique()->nullable();
        });

        Schema::table('ventes', function (Blueprint $table) {
            $table->string('numero_vente')->unique()->nullable();
        });
    }

    public function down()
    {
        Schema::table('achats', function (Blueprint $table) {
            $table->dropColumn('numero_achat');
        });

        Schema::table('ventes', function (Blueprint $table) {
            $table->dropColumn('numero_vente');
        });
    }
};
