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

        // user yang melakukan pembelian
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        $table->decimal('total_price', 12, 2)->default(0);
        $table->string('status')->default('pending'); 
        // contoh status: pending, paid, shipped, completed, canceled

        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('orders');
}

};
