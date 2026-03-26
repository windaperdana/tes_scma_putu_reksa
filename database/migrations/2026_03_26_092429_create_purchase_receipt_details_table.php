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
        Schema::create('purchase_receipt_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_receipt_id')->constrained('purchase_receipts')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->integer('quantity_received');
            $table->decimal('price', 15, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Composite indexes for better join performance
            $table->index(['purchase_receipt_id', 'item_id']);
        });
        
        // Set MySQL engine to InnoDB for transaction support
        DB::statement('ALTER TABLE purchase_receipt_details ENGINE = InnoDB');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_receipt_details');
    }
};
