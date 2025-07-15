<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'service_id',
        'quantity',
        'state',
        'price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // State constants
    const STATE_DRAFT = 'draft';
    const STATE_SENT = 'sent';
    const STATE_IN_PROGRESS = 'in_progress';
    const STATE_CANCELLED = 'cancelled';
    const STATE_UNPAID = 'unpaid';
    const STATE_COMPLETE = 'complete';

    // Get all possible states
    public static function getStates()
    {
        return [
            self::STATE_DRAFT,
            self::STATE_SENT,
            self::STATE_IN_PROGRESS,
            self::STATE_CANCELLED,
            self::STATE_UNPAID,
            self::STATE_COMPLETE,
        ];
    }

    // Optional: checkers
    public function isDraft()
    {
        return $this->state === self::STATE_DRAFT;
    }

    public function isComplete()
    {
        return $this->state === self::STATE_COMPLETE;
    }

    // ...tambahkan metode sejenis jika perlu
}