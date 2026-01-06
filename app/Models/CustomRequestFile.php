<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomRequestFile extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function customRequest(): BelongsTo { return $this->belongsTo(CustomRequest::class); }
}
