<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Designer extends Model
{
    use HasFactory;
     protected $guarded = [];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function designs(): HasMany { return $this->hasMany(Design::class); }

    public function ratings() {return $this->hasMany(\App\Models\Rating::class); }
    public function avgRating()
    {
        return $this->ratings()->selectRaw('designer_id, AVG(stars) as agg')->groupBy('designer_id');
    }
}
