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
        Schema::table('orders', function (Blueprint $t) {
            $t->enum('shipping_method', ['digital','ship'])->default('digital')->after('payment_status');
            $t->enum('shipping_status', ['pending','packed','shipped','delivered'])->nullable()->after('shipping_method');

            // alamat penerima
            $t->string('ship_name')->nullable();
            $t->string('ship_phone')->nullable();
            $t->string('ship_address')->nullable();
            $t->string('ship_city')->nullable();
            $t->string('ship_province')->nullable();
            $t->string('ship_postal_code', 10)->nullable();

            // logistik
            $t->string('shipping_courier')->nullable();
            $t->string('shipping_tracking_no')->nullable();
            $t->unsignedBigInteger('shipping_fee')->default(0);

            $t->timestamp('shipped_at')->nullable();
            $t->timestamp('delivered_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $t) {
            $t->dropColumn([
                'shipping_method','shipping_status',
                'ship_name','ship_phone','ship_address','ship_city','ship_province','ship_postal_code',
                'shipping_courier','shipping_tracking_no','shipping_fee',
                'shipped_at','delivered_at'
            ]);
        });
    }
};
