<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGroupeVentesIdToVentesTable extends Migration
{
    public function up()
    {
        Schema::table('ventes', function (Blueprint $table) {
            // Vérifiez si la colonne existe avant de l'ajouter
            if (!Schema::hasColumn('ventes', 'groupe_ventes_id')) {
                $table->unsignedBigInteger('groupe_ventes_id')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('ventes', function (Blueprint $table) {
            // Vérifiez si la colonne existe avant de tenter de la supprimer
            if (Schema::hasColumn('ventes', 'groupe_ventes_id')) {
                $table->dropColumn('groupe_ventes_id');
            }
        });
    }
}