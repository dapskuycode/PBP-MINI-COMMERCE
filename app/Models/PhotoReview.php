<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoReview extends Model
{
    use HasFactory;

    protected $table = 'photo_reviews';

    protected $fillable = ['review_id', 'url'];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}
