<?php

// app/Services/FileUploadService.php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    public function uploadFile($file)
    {
        $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();

        /** @var Illuminate\Filesystem\FilesystemAdapter */
        $filesystem = Storage::disk('public');
        $filesystem->putFileAs('/CelebrantPhoto', $file, $fileName);

        return 'CelebrantPhoto/' . $fileName;
    }
}