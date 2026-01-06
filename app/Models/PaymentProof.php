<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentProof extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function order(): BelongsTo { return $this->belongsTo(Order::class); }
    public function uploader(): BelongsTo { return $this->belongsTo(User::class, 'uploader_id'); }
    public function reviewer(): BelongsTo { return $this->belongsTo(User::class, 'reviewed_by'); }
}
