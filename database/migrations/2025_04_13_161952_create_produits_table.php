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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('code')->unique(); // code produit
            $table->string('categorie')->nullable(); // ex: matériel, consommable, etc.
            $table->integer('quantite_stock')->default(0);
            $table->decimal('prix_achat', 10, 2)->nullable();
            $table->decimal('prix_vente', 10, 2)->nullable();
            $table->integer('seuil_alerte')->nullable(); // seuil pour alerte de stock bas
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
