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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_number', 50)->unique();
            $table->foreignId('purchase_request_id')->constrained('purchase_requests')->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->date('order_date');
            $table->date('expected_date')->nullable();
            $table->decimal('total_amount', 15, 2)->default(0)->index();
            $table->enum('status', ['draft', 'pending', 'approved', 'completed', 'cancelled'])->default('draft')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes for better query performance
            $table->index('order_date');
            $table->index('expected_date');
            $table->index(['supplier_id', 'status']);
            $table->index(['status', 'order_date']);
        });
        
        // Set MySQL engine to InnoDB for transaction support
        DB::statement('ALTER TABLE purchase_orders ENGINE = InnoDB');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
