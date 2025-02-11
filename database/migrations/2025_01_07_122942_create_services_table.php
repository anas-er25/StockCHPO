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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->enum('type', ['departement', 'pole', 'service', 'unite', 'bureau', 'centre'])->nullable();
            $table->foreignId('hopital_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('services')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};