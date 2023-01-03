<?php

namespace App\Common;

use Symfony\Component\String\Slugger\SluggerInterface;

class CommonFunction
{

    public static function generateFileName($object, SluggerInterface $slugger) :string
    {
        $originalFilename = pathinfo($object->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid();
        return $newFilename;
    }

    public static function uploadImageToServerFromUrl(string $url, $fileName ,$pathOnServer) {

        try {
            $imageCode = file_get_contents($url);
            if(!is_dir($pathOnServer)){
                mkdir($pathOnServer,0755,true);
            }
            file_put_contents( $pathOnServer . '\\' . $fileName, $imageCode);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }


}