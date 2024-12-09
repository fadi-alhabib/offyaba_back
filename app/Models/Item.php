<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_id',
        'name',
        'price',
        'discount',
        'image'
    ];

    public function clothingItem(): HasOne
    {
        return $this->hasOne(ClothingItem::class,'item_id','id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class,'store_id','id');
    }
}
