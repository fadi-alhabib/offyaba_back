<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'store_id', 'total', 'status', 'location', 'phone'];

    public const PENDING = 'يتم تأكيد الطلب';
    public const ACCEPTED = 'تم تأكيد الطلب';
    public const CANCELLED = 'تم إلغاء الطلب';
    public const DELIVERED = 'يتم إيصال الطلب';

    protected $casts = [
        'status' => 'string',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
