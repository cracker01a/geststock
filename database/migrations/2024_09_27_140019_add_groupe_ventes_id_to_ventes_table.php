<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('ventes', function (Blueprint $table) {
        $table->unsignedBigInteger('groupe_ventes_id')->nullable();
        $table->foreign('groupe_ventes_id')->references('id')->on('groupe_ventes')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('ventes', function (Blueprint $table) {
        $table->dropForeign(['groupe_ventes_id']);
        $table->dropColumn('groupe_ventes_id');
    });
}
};
