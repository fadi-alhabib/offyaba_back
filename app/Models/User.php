<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Traits\HasImage;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasImage;
    protected $fillable = ['name', 'phone_number', 'latitude', 'longitude', 'image', 'firebase_token'];

    public function qrCodes(): HasMany
    {
        return $this->hasMany(QrCode::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }
}
