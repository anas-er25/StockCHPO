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
            $table->string('designation');
            $table->integer('qte');
            $table->enum('type', ['hospitalier', 'bureau', 'biomédical']); // Remplacez par les types
            $table->enum('origin', ['achat', 'don']); // Remplacez par les origines
            $table->string('marque');
            $table->string('modele');
            $table->string('num_serie')->nullable();
            $table->date('date_inscription');
            $table->date('date_affectation')->nullable();
            $table->foreignId('service_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('observation')->nullable();
            $table->enum('etat', ['réceptionné', 'affecté', 'en mouvement', 'réformé']); // Remplacez par les états
            $table->string('numero_marche')->nullable();
            $table->string('numero_bl')->nullable();
            $table->string('nom_societe')->nullable();
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