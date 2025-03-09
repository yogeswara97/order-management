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
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null');
            $table->date('order_date');
            $table->string('reference_number')->nullable();
            $table->string('order_number')->nullable();
            $table->string('object')->nullable();
            $table->string('cargo')->nullable();
            $table->string('status')->default('new');
            $table->string('currency',3);
            $table->integer('exchange_rate')->default('1')->nullable();
            $table->integer('total')->default('0')->nullable();
            $table->integer('vat')->default('0')->nullable();
            $table->integer('vat_total')->default('0')->nullable();
            $table->bigInteger('grand_total')->default('0')->nullable();
            $table->integer('deposit_amount')->default('0')->nullable();
            $table->string('deposit_description')->nullable();
            $table->longText('terms_conditions')->nullable();
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
