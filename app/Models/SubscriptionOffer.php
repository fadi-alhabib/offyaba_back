<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SubscriptionOffer extends Model
{
    use HasFactory;

    protected $table = 'subscription_offers';
    protected $guarded = ['id'];

    public function total() : Attribute {
        return Attribute::make(
            get: fn() => $this['cost'] * $this['period']
        );
    }

    public function totalWithDiscount() : Attribute {
        return Attribute::make(
          get: fn() => $this['total'] - $this['total'] * $this['discount'] / 100
        );
    }
}
