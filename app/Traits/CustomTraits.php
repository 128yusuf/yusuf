<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

trait CustomTraits
{

    public function createDirectory($path)
    {
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
    }

    public function saveCustomFileAndGetImageName($image, $path)
    {
        $newImageName = $image->getFilename() . time() . '.' . $image->getClientOriginalExtension();
        $image->move($path, $newImageName);
        return $newImageName;
    }

    public function removeOldImage($image,$path) {
        $oldImage = $path.'/'.$image;
        if (File::exists($oldImage)) {
            unlink($oldImage);
        }
    }


    public static function getPriceWithCurrency($price) {
        if(Auth::user()->currency == config('constant.currency')['EUR'])
            return '€'.$price;

        return '$'.$price;
    }

    public static function getCurrencySymbol() {
        if(Auth::user()->currency == config('constant.currency')['EUR'])
            return '€';

        return '$';
    }
}
