<?php


namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserUploadService
{
    public function uploadFile($file)
    {
        $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();

        /** @var Illuminate\Filesystem\FilesystemAdapter */
        $filesystem = Storage::disk('public');
        $filesystem->putFileAs('/UserPhoto', $file, $fileName);

        return 'UserPhoto/' . $fileName;
    }
}