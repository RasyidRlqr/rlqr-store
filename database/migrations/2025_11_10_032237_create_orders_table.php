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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            // Kolom Relasi (Kritis agar Order tersimpan)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict'); // <-- KOLOM WAJIB
            $table->foreignId('game_id')->constrained('games')->onDelete('restrict'); 
            
            // Kolom Data Pesanan
            $table->string('invoice_number')->unique();
            $table->string('game_user_id'); 
            $table->string('game_user_server')->nullable();
            $table->string('contact_whatsapp'); 
            $table->unsignedInteger('total_price');
            $table->string('payment_method')->nullable();
            $table->enum('status', ['pending', 'paid', 'processing', 'completed', 'failed', 'canceled'])->default('pending');
            $table->text('admin_notes')->nullable(); 
            $table->timestamp('paid_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};