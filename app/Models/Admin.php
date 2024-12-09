<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable=['username','password'];

    protected $hidden=[
        'password',
        'created_at',
        'updated_at'
    ];

    protected $casts=[
        'password' =>'hashed'
    ];


}
