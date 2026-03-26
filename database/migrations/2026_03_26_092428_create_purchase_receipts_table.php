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
        Schema::create('purchase_receipts', function (Blueprint $table) {
            $table->id();
            $table->string('pb_number', 50)->unique();
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->onDelete('cascade');
            $table->date('receipt_date');
            $table->enum('status', ['draft', 'partial', 'completed'])->default('draft')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes for better query performance
            $table->index('receipt_date');
            $table->index(['purchase_order_id', 'status']);
            $table->index(['status', 'receipt_date']);
        });
        
        // Set MySQL engine to InnoDB for transaction support
        DB::statement('ALTER TABLE purchase_receipts ENGINE = InnoDB');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_receipts');
    }
};
