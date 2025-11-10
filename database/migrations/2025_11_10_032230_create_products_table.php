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
        Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->foreignId('game_id')->constrained('games')->onDelete('cascade'); // <-- HARUS ADA
    $table->string('name'); 
    $table->unsignedInteger('price'); 
    $table->unsignedInteger('nominal'); 
    $table->boolean('is_active')->default(true); // <-- HARUS ADA
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
