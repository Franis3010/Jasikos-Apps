<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
     protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
<<<<<<< HEAD
=======
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',         // ← add this
    ];
>>>>>>> b83671218a72768156921f193e46e08c4ea4ba4b

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


<<<<<<< HEAD
    public function designer(): HasOne { return $this->hasOne(Designer::class); }
    public function customer(): HasOne { return $this->hasOne(Customer::class); }
=======
    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
>>>>>>> b83671218a72768156921f193e46e08c4ea4ba4b
}
