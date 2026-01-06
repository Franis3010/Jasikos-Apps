<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function isCancellable(): bool
    {
        // Block cancel kalau sudah ada item yang terkirim/selesai
        $hasDelivered = $this->items()
            ->whereIn('item_status', ['delivered','completed'])
            ->exists();

        return $this->payment_status !== 'paid'
            && !$hasDelivered
            && $this->status !== 'cancelled';
    }

    // app/Models/Order.php
    public function isStartable(): bool
    {
        return is_null($this->work_started_at)
            && $this->status !== 'canceled'
            && $this->payment_status === 'paid'; // kalau mau longgar, ubah sesuai kebijakanmu
    }
    public function customer(): BelongsTo { return $this->belongsTo(Customer::class); }
    public function designer(): BelongsTo { return $this->belongsTo(Designer::class); }
    public function items(): HasMany { return $this->hasMany(OrderItem::class); }
    public function paymentProofs(): HasMany { return $this->hasMany(PaymentProof::class); }
    public function statusLogs(): HasMany { return $this->hasMany(OrderStatusLog::class); }

    public function rating() {return $this->hasOne(\App\Models\Rating::class); }
}
