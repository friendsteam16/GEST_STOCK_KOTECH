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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('designation');
            $table->string('reference')->nullable();
            $table->text('description')->nullable();
            $table->integer('stock')->default(0);
            $table->decimal('prix_unitaire', 10, 2)->nullable();
        
            // ✅ Une seule ligne par relation avec clé étrangère
            $table->foreignId('categorie_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('fournisseur_id')->nullable()->constrained('fournisseurs')->nullOnDelete();
        
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
