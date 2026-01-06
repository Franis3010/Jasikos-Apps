<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key','value'];
    public $timestamps = true;

    public static function getValue(string $key, $default=null) {
        return cache()->remember("setting:$key", 3600, function() use ($key,$default){
            $row = static::query()->where('key',$key)->first();
            return $row?->value ?? $default;
        });
    }
    public static function put(string $key, $value): void {
        static::updateOrCreate(['key'=>$key], ['value'=>$value]);
        cache()->forget("setting:$key");
    }
}
