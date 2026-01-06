<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $t) {
            // siapa & kapan cancel
            $t->timestamp('canceled_at')->nullable()->after('status');
            $t->foreignId('canceled_by')->nullable()->after('canceled_at')
              ->constrained('users')->nullOnDelete();
            $t->text('cancel_reason')->nullable()->after('canceled_by');

            // kapan designer mulai kerja
            $t->timestamp('work_started_at')->nullable()->after('cancel_reason');

            // index kecil biar query gampang
            $t->index(['status', 'payment_status']);
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $t) {
            $t->dropIndex(['status', 'payment_status']);
            $t->dropConstrainedForeignId('canceled_by');
            $t->dropColumn(['canceled_at','cancel_reason','work_started_at']);
        });
    }
};
