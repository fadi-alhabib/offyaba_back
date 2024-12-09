<?php

namespace App\Models;

use App\Services\CoordsServices;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Store extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function workHours(): HasMany
    {
        return $this->hasMany(WorkHour::class)->orderBy('week_day');
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function clothingItems(): HasManyThrough
    {
        return $this->hasManyThrough(ClothingItem::class, Item::class);
    }

    public function distance(): Attribute
    {
        return Attribute::get(function () {
            $coords = CoordsServices::getCoordsAndUpdate();
            if (!$coords) return null;

            return $this->haversine(
                $this['latitude'],
                $this['longitude'],
                $coords['latitude'],
                $coords['longitude']
            );
        }
        );
    }

    private function haversine($lat1, $lng1, $lat2, $lng2): float
    {
        $lat1 = deg2rad($lat1);
        $lat2 = deg2rad($lat2);
        $lng1 = deg2rad($lng1);
        $lng2 = deg2rad($lng2);
        $earthRadius = 6371;
        $latDelta = $lat1 - $lat2;
        $lngDelta = $lng1 - $lng2;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2)
                + cos($lat1) * cos($lat2) * pow(sin($lngDelta / 2), 2)));

        return $angle * $earthRadius;
    }
}
