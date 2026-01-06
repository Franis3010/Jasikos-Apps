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
          Schema::create('categories', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('slug')->unique();
            $t->timestamps();
        });

        Schema::create('category_design', function (Blueprint $t) {
            $t->foreignId('design_id')->constrained('designs')->cascadeOnDelete();
            $t->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $t->primary(['design_id','category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_design');
        Schema::dropIfExists('categories');
    }
};
