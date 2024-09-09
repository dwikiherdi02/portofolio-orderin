<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('order_no');
            $table->date('ordered_at');
            $table->uuid('customer_id');
            $table->integer('total_items')->default(0);
            $table->decimal('total_price', 12, 2)->default(0.00);
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            // $table->index('customer_id', 'orders_customer_id_index');
            $table->primary('id', 'orders_id_primary');
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
