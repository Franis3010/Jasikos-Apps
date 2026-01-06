<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDeliverable extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function orderItem(): BelongsTo { return $this->belongsTo(OrderItem::class); }

}
