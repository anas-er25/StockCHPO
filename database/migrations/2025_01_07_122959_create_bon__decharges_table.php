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
        Schema::create('bon__decharges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained()->onDelete('cascade');
            $table->integer('qte');
            $table->string('num_serie')->nullable();
            $table->foreignId('cedant_id')->constrained('services')->onDelete('cascade');
            $table->foreignId('cessionnaire_id')->constrained('services')->onDelete('cascade');
            $table->string('motif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bon__decharges');
    }
};
