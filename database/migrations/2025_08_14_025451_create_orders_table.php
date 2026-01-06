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
        Schema::create('orders', function (Blueprint $t) {
            $t->id();
            $t->string('code')->unique();
            $t->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $t->foreignId('designer_id')->constrained('designers')->cascadeOnDelete();
            $t->enum('status', ['awaiting_payment','processing','delivered','completed','cancelled','declined'])->default('awaiting_payment');
            $t->enum('payment_status', ['unpaid','submitted','paid','rejected'])->default('unpaid');
            // snapshot tujuan bayar
            $t->string('pay_bank_name')->nullable();
            $t->string('pay_bank_account_no')->nullable();
            $t->string('pay_qris_image')->nullable();
            $t->unsignedBigInteger('subtotal')->default(0);
            $t->unsignedBigInteger('fee')->default(0);
            $t->unsignedBigInteger('total')->default(0);
            $t->text('note')->nullable();
            $t->timestamp('paid_at')->nullable();
            $t->timestamps();
        });

        // order_items
        Schema::create('order_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $t->foreignId('design_id')->constrained('designs')->cascadeOnDelete();
            $t->foreignId('designer_id')->constrained('designers')->cascadeOnDelete();
            $t->string('title_snapshot');
            $t->unsignedBigInteger('price_snapshot');
            $t->unsignedSmallInteger('qty')->default(1);
            $t->enum('item_status', ['processing','delivered','revised','completed','cancelled'])->default('processing');
            $t->timestamps();
        });

        // payment_proofs
        Schema::create('payment_proofs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $t->foreignId('uploader_id')->constrained('users')->cascadeOnDelete();
            $t->string('image_path');
            $t->unsignedBigInteger('amount')->nullable();
            $t->string('payer_name')->nullable();
            $t->enum('status', ['submitted','accepted','rejected'])->default('submitted');
            $t->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $t->timestamp('reviewed_at')->nullable();
            $t->timestamps();
        });

        // order_status_logs
        Schema::create('order_status_logs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $t->string('from_status')->nullable();
            $t->string('to_status');
            $t->foreignId('changed_by')->constrained('users')->cascadeOnDelete();
            $t->text('note')->nullable();
            $t->timestamps();
        });

        // order_deliverables
        Schema::create('order_deliverables', function (Blueprint $t) {
            $t->id();
            $t->foreignId('order_item_id')->constrained('order_items')->cascadeOnDelete();
            $t->string('file_path');
            $t->enum('visible_after', ['paid','delivered','completed'])->default('paid');
            $t->unsignedSmallInteger('download_limit')->nullable();
            $t->timestamp('expires_at')->nullable();
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_deliverables');
        Schema::dropIfExists('order_status_logs');
        Schema::dropIfExists('payment_proofs');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');

    }
};
