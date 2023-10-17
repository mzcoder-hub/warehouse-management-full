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
        Schema::create('sales_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_id')->constrained()->onDelete('cascade');
            $table->integer('inventory_id');
            $table->integer('qty');
            $table->double('price');
            $table->double('price_sale')->nullable();
            $table->enum('status', ['wait_for_proccess', 'ongoing', 'complete', 'return'])->default('wait_for_proccess');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_details');
    }
};
