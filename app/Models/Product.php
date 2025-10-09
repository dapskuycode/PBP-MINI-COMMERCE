<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'discount',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function photos()
    {
        return $this->hasMany(ItemPhoto::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Format price to Indonesian Rupiah
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format((float)$this->price, 0, ',', '.');
    }

    // Get discounted price
    public function getDiscountedPriceAttribute()
    {
        if ($this->discount > 0) {
            return $this->price * (1 - ($this->discount / 100));
        }
        return $this->price;
    }

    // Format discounted price to Indonesian Rupiah
    public function getFormattedDiscountedPriceAttribute()
    {
        return 'Rp ' . number_format((float)$this->discounted_price, 0, ',', '.');
    }

    // Check if product has discount
    public function getHasDiscountAttribute()
    {
        return $this->discount > 0;
    }
}
