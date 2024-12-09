<?php

namespace App\Http\Controllers;

use App\Services\ImageServices;
use Exception;
use function request;

class ImageController extends Controller
{
    public function __invoke()
    {

        $path = request('path');
        if(!$path) return $this->failed('Not found!', 404);
        try {
            return ImageServices::get($path);
        }catch (Exception $exception){
            return $this->failed($exception->getMessage(), 404);
        }
    }
}
