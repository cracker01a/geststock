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
    // Supprimer la contrainte unique temporairement
    Schema::table('ventes', function (Blueprint $table) {
        $table->dropUnique('unique_numero_achat');
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
        $table->dropColumn('numero_achat');
    });
}
    
    public function down()
    {
        Schema::table('achats', function (Blueprint $table) {
            $table->string('numero_achat')->unique()->nullable();
        });
    
        // Optionnel : Pour remettre les données en place
        DB::table('achats')->join('ventes', 'achats.ventes_id', '=', 'ventes.id')
            ->update(['achats.numero_achat' => DB::raw('ventes.numero_achat')]);
    
        Schema::table('ventes', function (Blueprint $table) {
            $table->dropUnique('unique_numero_achat');
            $table->dropColumn('numero_achat');
        });
    }
    
}