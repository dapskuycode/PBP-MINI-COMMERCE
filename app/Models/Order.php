<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'total', 'status', 'address', 'nama_pemesan', 'kota', 'kode_pos', 'nomor_hp', 'jenis_pengiriman', 'metode_pembayaran', 'nomor_resi'
    ];

    /**
     * Generate formatted order ID (ORD0001, ORD1243, ORD12354)
     */
    public function getFormattedIdAttribute()
    {
        return 'ORD' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Static method to generate formatted order ID
     */
    public static function formatOrderId($id)
    {
        return 'ORD' . str_pad($id, 4, '0', STR_PAD_LEFT);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
