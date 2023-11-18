<?php

// app/Services/FileUploadService.php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    public function uploadFile($file, $photo_directory)
    {
        $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();

        /** @var Illuminate\Filesystem\FilesystemAdapter */
        $filesystem = Storage::disk('public');
        $filesystem->putFileAs("/$photo_directory", $file, $fileName);

        return "$photo_directory/" . $fileName;
    }
}