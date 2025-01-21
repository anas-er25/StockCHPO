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
        Schema::create('material_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id');
            $table->unsignedBigInteger('from_service_id')->nullable();
            $table->unsignedBigInteger('to_service_id')->nullable();
            $table->timestamp('moved_at')->useCurrent();
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
            $table->foreign('from_service_id')->references('id')->on('services')->onDelete('set null');
            $table->foreign('to_service_id')->references('id')->on('services')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_histories');
    }
};