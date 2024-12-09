<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClothingItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'type_id',
        'sizes',
        'target_group',
        'colors',
        'material',
    ];

    protected $casts=[
      'sizes'=>'array',
      'colors'=>'array',
    ];
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(ClothingType::class, 'type_id', 'id');
    }
}
