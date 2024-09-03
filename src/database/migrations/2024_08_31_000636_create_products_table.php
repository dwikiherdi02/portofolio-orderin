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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name', 150);
            $table->decimal('price', total: 8, places: 2);
            $table->text('categories')->nullable();
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->primary('id', 'products_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
