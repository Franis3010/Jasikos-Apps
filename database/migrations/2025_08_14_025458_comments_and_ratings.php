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
           Schema::create('comments', function (Blueprint $t) {
            $t->id();
            $t->morphs('commentable'); // commentable_type, commentable_id
            $t->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $t->text('message');
            $t->timestamps();
        });

        Schema::create('ratings', function (Blueprint $t) {
            $t->id();
            $t->foreignId('order_id')->unique()->constrained('orders')->cascadeOnDelete();
            $t->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $t->foreignId('designer_id')->constrained('designers')->cascadeOnDelete();
            $t->unsignedTinyInteger('stars'); // 1..5
            $t->text('review')->nullable();
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
        Schema::dropIfExists('comments');

    }
};
