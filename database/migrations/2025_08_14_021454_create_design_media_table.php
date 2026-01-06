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
        Schema::create('design_media', function (Blueprint $t) {
            $t->id();
            $t->foreignId('design_id')->constrained('designs')->cascadeOnDelete();
            $t->enum('type', ['image','video'])->default('image');
            $t->string('path');
            $t->unsignedInteger('sort_order')->default(0);
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('design_media');
    }
};
