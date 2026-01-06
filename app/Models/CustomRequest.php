<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, MorphMany};

class CustomRequest extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = ['reference_links' => 'array'];

    public function customer(): BelongsTo { return $this->belongsTo(Customer::class); }
    public function designer(): BelongsTo { return $this->belongsTo(Designer::class); }
    public function files(): HasMany { return $this->hasMany(CustomRequestFile::class); }
    public function comments(): MorphMany { return $this->morphMany(Comment::class, 'commentable'); }
}
