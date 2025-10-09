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

    /**
     * Get the product that owns the photo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the full URL for the photo
     */
    public function getFullUrlAttribute()
    {
        return Storage::url($this->url);
    }

    /**
     * Get the absolute path for the photo
     */
    public function getAbsoluteUrlAttribute()
    {
        return asset('storage/' . $this->url);
    }

    /**
     * Check if this photo exists in storage
     */
    public function exists()
    {
        return Storage::disk('public')->exists($this->url);
    }

    /**
     * Scope to get primary photos only
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope to get non-primary photos only
     */
    public function scopeSecondary($query)
    {
        return $query->where('is_primary', false);
    }

    /**
     * Auto-delete file when model is deleted
     */
    protected static function booted()
    {
        static::deleted(function ($photo) {
            if ($photo->exists()) {
                Storage::disk('public')->delete($photo->url);
            }
        });
    }
}
