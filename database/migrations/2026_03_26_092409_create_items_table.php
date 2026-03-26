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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->string('unit', 20);
            $table->decimal('price', 15, 2)->default(0)->index();
            $table->integer('stock')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            
            // Indexes for better query performance
            $table->index('name');
            $table->index(['is_active', 'code']);
            $table->index(['is_active', 'stock']);
        });
        
        // Set MySQL engine to InnoDB for transaction support
        DB::statement('ALTER TABLE items ENGINE = InnoDB');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
