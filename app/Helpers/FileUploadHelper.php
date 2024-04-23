<?php

namespace App\Helpers;

class FileUploadHelper
{
    public static function imageUpload($file, $folderName)
    {
        $pubPath = public_path($folderName);
        $imageName = time() . '.' . $file->extension();
        $file->move($pubPath, $imageName);
        return $imageName;
    }

    public static function imageDelete($imageName, $folderName)
    {
        $path = public_path() . '/' . $folderName . '/';
        $imageOld = $path . $imageName;
        if (file_exists($imageOld)) {
            return unlink($imageOld);
        }
    }
}
