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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('num_inventaire')->unique();
            $table->string('designation')->nullable();
            $table->integer('qte')->nullable();
            $table->enum('type', ['hospitalier', 'bureau', 'biomédical'])->nullable();
            $table->enum('origin', ['achat', 'don'])->nullable();
            $table->string('marque')->nullable();
            $table->string('modele')->nullable();
            $table->string('num_serie')->nullable();
            $table->date('date_inscription')->nullable();
            $table->date('date_affectation')->nullable();
            $table->foreignId('service_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('observation')->nullable();
            $table->enum('etat', ['réceptionné', 'affecté', 'en mouvement', 'réformé', 'colis fermé'])->nullable();
            $table->foreignId('societe_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};