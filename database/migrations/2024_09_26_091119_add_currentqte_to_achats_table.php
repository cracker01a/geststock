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
        $table->integer('currentqte')->after('users_id')->default(0); // Ajoute la colonne après 'users_id'
    });
}

public function down()
{
    Schema::table('achats', function (Blueprint $table) {
        $table->dropColumn('currentqte');
    });
}

};
