<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use StdClass;

class UploadFileController extends Controller
{
    public function upload(Request $request)
    {
        $files = $request->file('file');
        $multiple = is_array($files);
        $response = $multiple ? [] : $this->packResponse($files);
        if ($multiple) {
            foreach ($files as $file) {
                $response[] = $this->packResponse($file);
            }
        }
        return response()->json($response);
    }

    private function packResponse(UploadedFile $file)
    {
        $json = new StdClass();
        $json->name = $file->getClientOriginalName();
        $json->mime = $file->getClientMimeType();
        $json->path = $file->storePubliclyAs('', $this->getPublicName($file), 'public');
        $json->path = $this->resize($json->path, 100, 250);
        $json->url = asset('storage/' . $json->path);
        return $json;
    }

    private function getPublicName(UploadedFile $file)
    {
        if (!$file->guessExtension()) {
            return uniqid('', true) . '.' . $file->clientExtension();
        } else {
            return $file->hashName();
        }
    }

    private function resize($file, $maxSize)
    {
        $filePath = \storage_path('app/public/' . $file);
        $src = imagecreatefromstring(file_get_contents($filePath));
        $size = getimagesize($filePath);
        $ratio = $size[0] / $size[1];

        $targetWidth = 1200;
        $targetHeight = $targetWidth / $ratio;
        $dst = $this->resample($src, $size, $targetWidth, $targetHeight);

        $quality = 100;
        $minQuality = 75;
        $target = "{$filePath}.jpg";
        for ($i=0; $i < 15; $i++) {
            imagejpeg($dst, $target, $quality);
            $filesize = \filesize($target) / 1000;
            if ($filesize > $maxSize) {
                $quality -= 5;
                if ($quality < $minQuality) {
                    $quality = 100;
                    $targetWidth -= 100;
                    $targetHeight = \floor($targetWidth / $ratio);
                    imagedestroy($dst);
                    $dst = $this->resample($src, $size, $targetWidth, $targetHeight);
                }
            } else {
                break;
            }
        }
        imagedestroy($dst);
        imagedestroy($src);
        unlink($filePath);
        return basename($target);
    }

    private function resample($src, array $size, $width, $height)
    {
        $dst = imagecreatetruecolor($width, $height);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
        return $dst;
    }
}
