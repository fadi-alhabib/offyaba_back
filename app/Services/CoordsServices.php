<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class CoordsServices
{
    public static function getCoordsAndUpdate(): ?array
    {
        $latitude = request('latitude');
        $longitude = request('longitude');
        $user = auth('user-api')->user();
        if (self::validate($latitude, $longitude)) {
            $user?->update([
                'latitude' => $latitude,
                'longitude' => $longitude
            ]);
            return [
                'latitude' => $latitude,
                'longitude' => $longitude,
            ];
        }

        if($user && self::validate($user['latitude'], $user['longitude']))
        {
            return [
                'latitude' => $user['latitude'],
                'longitude' => $user['longitude'],
            ];
        }

        return null;
    }

    private static function validate($latitude, $longitude): bool
    {
        $validate = Validator::make([
                'latitude' => $latitude,
                'longitude' => $longitude,
            ],
            [
                'latitude' => ['required', 'numeric', 'between:-90,90'],
                'longitude' => ['required', 'numeric', 'between:-180,180']
            ]);
        return !$validate->fails();
    }
}
