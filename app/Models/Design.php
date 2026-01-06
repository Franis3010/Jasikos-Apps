<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Design extends Model
{
    use HasFactory;
      use HasFactory;
    protected $guarded = [];

    public function designer(): BelongsTo { return $this->belongsTo(Designer::class); }
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_design', 'design_id', 'category_id');
    }
    public function media(): HasMany { return $this->hasMany(DesignMedia::class); }
}
