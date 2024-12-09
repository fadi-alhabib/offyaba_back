<?php

namespace App\Traits;

use App\Services\ImageServices;

trait HasImage
{
    public function upload($image): string
    {
        if ($this['image']){
            $this['image'] = ImageServices::update($image, $this['image']);
        }else{
            $this['image'] = ImageServices::save($image, 'User');
        }
        $this->save();
        return $this['image'];
    }

    public function deleteImage(): void
    {
        ImageServices::delete($this['image']);
        $this['image'] = null;
        $this->save();
    }
}
