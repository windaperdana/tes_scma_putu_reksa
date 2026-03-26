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
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->string('pr_number', 50)->unique();
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->date('request_date');
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected', 'completed'])->default('draft')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes for better query performance
            $table->index('request_date');
            $table->index(['branch_id', 'status']);
            $table->index(['status', 'request_date']);
        });
        
        // Set MySQL engine to InnoDB for transaction support
        DB::statement('ALTER TABLE purchase_requests ENGINE = InnoDB');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requests');
    }
};
