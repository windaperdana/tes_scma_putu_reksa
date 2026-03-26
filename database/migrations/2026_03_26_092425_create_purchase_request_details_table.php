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
        Schema::create('purchase_request_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_request_id')->constrained('purchase_requests')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('estimated_price', 15, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Composite indexes for better join performance
            $table->index(['purchase_request_id', 'item_id']);
        });
        
        // Set MySQL engine to InnoDB for transaction support
        DB::statement('ALTER TABLE purchase_request_details ENGINE = InnoDB');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_request_details');
    }
};
