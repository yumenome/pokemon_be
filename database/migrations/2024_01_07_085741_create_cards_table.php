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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->unsignedBigInteger('per_price')->default(0);
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedBigInteger('selected')->default(1);
            $table->string('img');
            $table->unsignedBigInteger('total')->default(0);
            $table->boolean('is_active')->default(false);
            $table->string('type');
            $table->string('rarity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
