<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ItemPhoto extends Model
{
    use HasFactory;

    protected $table = 'item_photos';

    protected $fillable = [
        'product_id',
        'url',
        'alt_text',
        'is_primary'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getFullUrlAttribute()
    {
        return Storage::url($this->url);
    }

    public function getAbsoluteUrlAttribute()
    {
        return asset('storage/' . $this->url);
    }

    public function exists()
    {
        return Storage::disk('public')->exists($this->url);
    }

    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    public function scopeSecondary($query)
    {
        return $query->where('is_primary', false);
    }

    protected static function booted()
    {
        static::deleted(function ($photo) {
            if ($photo->exists()) {
                Storage::disk('public')->delete($photo->url);
            }
        });
    }
}
