<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    use HasFactory;


    protected $fillable = [
        'name', 'image'
    ];

    public function stores(): HasMany
    {
        return $this->hasMany(Store::class);
    }
}
