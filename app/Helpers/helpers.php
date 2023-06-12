<?php

if (!function_exists('parseImageBase64')) {
    function parseImageBase64($requestFile)
    {
        $base64Image = explode(";base64,", $requestFile);
        $explodeImage = explode("image/", $base64Image[0]);
        $ext = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);

        return [
            'image' => $image_base64,
            'filename' => md5($image_base64 . microtime()) . '.' . $ext
        ];
    }
}

if (!function_exists('stdResponse')) {
    function stdResponse($success, $message, $data = [])
    {
        return (object) ['success' => $success, 'message' => $message, 'data' => $data];
    }
}

if (!function_exists('isLoggedInUserID')) {
    function isLoggedInUserID()
    {
        return auth()->check() ? auth()->user()->id : false;
    }
}