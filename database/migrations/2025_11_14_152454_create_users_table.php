<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // data akun
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');

            //role
            $table->enum('role', ['customer', 'staff', 'admin'])->default('customer');

            //data tambahan
            $table->string('phone')->nullable();     // jika memerlukan nomor hp
            $table->string('avatar')->nullable();    // avatar
            $table->boolean('status')->default(1);

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
