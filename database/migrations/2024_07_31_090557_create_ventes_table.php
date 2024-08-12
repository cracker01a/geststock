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
        Schema::create('ventes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('achat_id');
            $table->unsignedBigInteger('site_id');
            $table->integer('quantity');
            $table->decimal('price', 8, 2);
            $table->decimal('total_price', 8, 2);
            $table->enum('status', ['non validée', 'validée']);
            $table->date('vente_date');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('achat_id')->references('id')->on('achats');
            $table->foreign('site_id')->references('id')->on('sites');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ventes');
    }
};
