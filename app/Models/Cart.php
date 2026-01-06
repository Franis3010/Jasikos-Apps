<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Factories\HasFactory;
=======
>>>>>>> b83671218a72768156921f193e46e08c4ea4ba4b
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
<<<<<<< HEAD
    use HasFactory;

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function items()
    {
        return $this->hasMany(CartItem::class);
=======
    protected $fillable = [
        'user_id',
        'service_id',
        'quantity',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
>>>>>>> b83671218a72768156921f193e46e08c4ea4ba4b
    }
}
