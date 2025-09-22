<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id'
    ];

    /**
     * Get the user that owns the cart.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the cart items for the cart.
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the total price of items in cart.
     */
    public function getTotalAttribute()
    {
        return $this->cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });
    }

    /**
     * Get the total quantity of items in cart.
     */
    public function getTotalQuantityAttribute()
    {
        return $this->cartItems->sum('quantity');
    }
}
