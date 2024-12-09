<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkHour extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function store() : BelongsTo {
        return $this->belongsTo(Store::class);
    }
}
