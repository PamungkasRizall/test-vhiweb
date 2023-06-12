<?php

namespace App\Services;

use App\Models\Photo;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Storage;

class UploadFileService
{
    public static function photos($id)
    {
        $mediaFile = request('image');

        if (!preg_match('/^data:image\/(\w+);base64,/', $mediaFile)) 
            return stdResponse(false, 'File Not Image Base64');

        $filename = parseImageBase64($mediaFile)['filename'];

        try {
            $photo = Photo::find($id);
            $photo->addMediaFromBase64($mediaFile)
                    ->usingFileName($filename)
                    ->toMediaCollection('photo');

            return stdResponse(true, 'File Upload Successfully');

        } catch (Exception $e) {

            return stdResponse(false, $e->getMessage());
        }
    }
}