<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    use HasFactory;
    protected $fillable = ['phone_number', 'code', 'type', 'sid'];
    protected $primaryKey = 'phone_number';
    protected $keyType = 'string';
    public $incrementing = false;
}
