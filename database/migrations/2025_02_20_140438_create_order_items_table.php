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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('image')->nullable();
            $table->string('item_name');
            $table->string('code')->nullable();
            $table->string('description')->nullable();
            $table->string('format')->nullable();
            $table->string('size_w')->nullable();
            $table->string('size_d')->nullable();
            $table->string('size_h')->nullable();
            $table->string('color')->nullable();
            $table->unsignedInteger('quantity');
            $table->string('unit')->nullable();
            $table->string('unit_price')->nullable();
            $table->string('total_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
