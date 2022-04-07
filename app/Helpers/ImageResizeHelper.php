<?php

namespace App\Helper;
use Image;

class Images
{
    public static function imageResize($fileName,$width,$height)
    {
        $image = Image::make($fileName);
        $image->resize($width,$height);
        return $image;
    }
}