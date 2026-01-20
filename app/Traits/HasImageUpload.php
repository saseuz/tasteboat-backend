<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

trait HasImageUpload
{
    public function saveImage($file, $folder = 'uploads', $width = 600, $height = 600)
    {
        $fileName = uniqid() . '_' . $file->getClientOriginalName();
        $path = "$folder/$fileName";

        $manager = new ImageManager(new Driver());

        $image = $manager->read($file)->resize($width, $height);
        $encodeImage = $image->toJpeg()->toString();

        Storage::disk('s3')->put($path, $encodeImage);

        return $fileName;
    }

    public function deleteOldImage($oldImage, $folder = 'uploads')
    {
        if ($oldImage && Storage::disk('s3')->exists("$folder/$oldImage")) {
            Storage::disk('s3')->delete("$folder/$oldImage");
        }
    }
}