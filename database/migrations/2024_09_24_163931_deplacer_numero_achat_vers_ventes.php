<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DeplacerNumeroAchatVersVentes extends Migration
{
    public function up()
    {
        // Ajouter la colonne achats_id à la table ventes si elle n'existe pas
        Schema::table('ventes', function (Blueprint $table) {
            if (!Schema::hasColumn('ventes', 'achats_id')) {
                $table->unsignedBigInteger('achats_id')->nullable(); // ou le type approprié
            }
        });

        // Ajouter la colonne numero_achat à la table ventes
        Schema::table('ventes', function (Blueprint $table) {
            $table->string('numero_achat')->nullable();
        });

        // Supprimer la contrainte unique temporairement si elle existe
        Schema::table('ventes', function (Blueprint $table) {
            if (Schema::hasIndex('ventes', 'unique_numero_achat')) {
                $table->dropUnique('unique_numero_achat');
            }
        });

        // Mettre à jour les données
        DB::table('ventes')
            ->join('achats', 'ventes.achats_id', '=', 'achats.id')
            ->update(['ventes.numero_achat' => DB::raw('achats.numero_achat')]);

        // Réappliquer la contrainte unique
        Schema::table('ventes', function (Blueprint $table) {
            $table->unique('numero_achat', 'unique_numero_achat');
        });

        // Supprimer la colonne de la table 'achats'
        Schema::table('achats', function (Blueprint $table) {
            if (Schema::hasColumn('achats', 'numero_achat')) {
                $table->dropColumn('numero_achat');
            }
        });
    }

    public function down()
    {
        Schema::table('achats', function (Blueprint $table) {
            if (!Schema::hasColumn('achats', 'numero_achat')) {
                $table->string('numero_achat')->unique()->nullable();
            }
        });

        // Optionnel : Pour remettre les données en place
        DB::table('achats')->join('ventes', 'achats.ventes_id', '=', 'ventes.id')
            ->update(['achats.numero_achat' => DB::raw('ventes.numero_achat')]);

        Schema::table('ventes', function (Blueprint $table) {
            if (Schema::hasIndex('ventes', 'unique_numero_achat')) {
                $table->dropUnique('unique_numero_achat');
            }
            $table->dropColumn('numero_achat');
            $table->dropColumn('achats_id'); // Si vous souhaitez revenir en arrière
        });
    }
}
