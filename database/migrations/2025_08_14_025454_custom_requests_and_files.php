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
                Schema::create('custom_requests', function (Blueprint $t) {
            $t->id();
            $t->string('code')->unique();
            $t->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $t->foreignId('designer_id')->constrained('designers')->cascadeOnDelete();
            $t->string('title');
            $t->longText('brief')->nullable();
            $t->json('reference_links')->nullable();
            $t->unsignedTinyInteger('revisions_allowed')->default(2);
            $t->unsignedTinyInteger('revisions_used')->default(0);
            $t->unsignedBigInteger('price_offer')->nullable();
            $t->unsignedBigInteger('price_agreed')->nullable();
            $t->enum('status', ['submitted','quoted','awaiting_payment','in_progress','delivered','completed','declined','cancelled'])->default('submitted');
            $t->timestamps();
        });

        Schema::create('custom_request_files', function (Blueprint $t) {
            $t->id();
            $t->foreignId('custom_request_id')->constrained('custom_requests')->cascadeOnDelete();
            $t->enum('type', ['reference','work_in_progress','final'])->default('reference');
            $t->string('path');
            $t->string('note')->nullable();
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('custom_request_files');
        Schema::dropIfExists('custom_requests');
    }
};
