<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'title',
        'body',
        'discount',
        'image'
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
