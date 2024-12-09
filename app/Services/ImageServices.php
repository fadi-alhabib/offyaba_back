<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ImageServices
{

    private static string $root = 'Image';

    public static function save($image, $path): string
    {
        $name = time() . '_IMG.' . $image->getClientOriginalExtension();
        Storage::putFileAs(self::$root . "/" . $path, $image, $name);
        return "$path/$name";
    }


    public static function update($image, $path): string
    {
        self::delete($path);
        return self::save($image, dirname($path));
    }

    public static function delete($path): void
    {
        $path = self::$root . "/" . $path;
        if (Storage::exists($path))
            Storage::delete($path);
    }

    /**
     * @throws Exception
     */
    public static function get($path): StreamedResponse
    {
        $path = self::$root . "/" . $path;

        if (Storage::exists($path))
            return Storage::download($path);
        else {
            throw new Exception('not found!');
        }
    }

}
