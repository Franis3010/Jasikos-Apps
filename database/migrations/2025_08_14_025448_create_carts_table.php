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
        Schema::create('carts', function (Blueprint $t) {
            $t->id();
            $t->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $t->timestamps();
        });

          Schema::create('cart_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('cart_id')->constrained('carts')->cascadeOnDelete();
            $t->foreignId('design_id')->constrained('designs')->cascadeOnDelete();
            $t->foreignId('designer_id')->constrained('designers')->cascadeOnDelete();
            $t->unsignedBigInteger('price_snapshot');
            $t->unsignedSmallInteger('qty')->default(1);
            $t->string('note')->nullable();
            $t->timestamps();
            $t->unique(['cart_id','design_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
    }
};
