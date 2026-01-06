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
        Schema::create('designs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('designer_id')->constrained()->cascadeOnDelete();
            $t->string('slug')->unique();
            $t->string('title');
            $t->longText('description')->nullable();
            $t->unsignedBigInteger('price');
            $t->enum('status', ['draft','published','archived'])->default('draft');
            $t->string('thumbnail')->nullable();
            $t->boolean('is_featured')->default(false);
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designs');
    }
};
