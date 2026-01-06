<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class OrderItem extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function order(): BelongsTo { return $this->belongsTo(Order::class); }
    public function design(): BelongsTo { return $this->belongsTo(Design::class); }
    public function designer(): BelongsTo { return $this->belongsTo(Designer::class); }
    public function deliverables(): HasMany { return $this->hasMany(OrderDeliverable::class); }

    public function comments(): MorphMany { return $this->morphMany(Comment::class, 'commentable'); }
}
