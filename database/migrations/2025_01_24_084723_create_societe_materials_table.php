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
        Schema::create('societe_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('societe_id')->constrained()->cascadeOnDelete();
            $table->foreignId('material_id')->constrained()->cascadeOnDelete();
            $table->string('numero_marche', 255)->nullable();
            $table->string('numero_bl', 255)->nullable();
            $table->string('PV', 255)->nullable();
            $table->string('CPS', 255)->nullable();
            $table->enum('observation', ['conformité technique', 'installation et mise en marche', 'formation', 'autres'])->nullable();
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('societe_materials');
    }
};