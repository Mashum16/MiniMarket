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

        // relasi ke orders
        $table->foreignId('order_id')->constrained()->onDelete('cascade');

        // relasi ke products
        $table->foreignId('product_id')->constrained()->onDelete('cascade');

        $table->integer('qty')->default(1);

        // harga saat pembelian (supaya history tetap benar meski harga produk berubah)
        $table->decimal('price_at_purchase', 12, 2);

        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('order_items');
}

};
