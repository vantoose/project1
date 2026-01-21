<?php

namespace App\Helpers;

class PhpConfigHelper
{
    public static function getUploadMaxFilesize()
    {
        return ini_get('upload_max_filesize');
    }
    
    public static function getPostMaxSize()
    {
        return ini_get('post_max_size');
    }
    
    public static function getUploadMaxFilesizeWithSizeUnits()
    {
        $upload_max_filesize = ini_get('upload_max_filesize');
        $bytes = FileHelper::convertToBytes($upload_max_filesize);
        return FileHelper::formatSizeUnits($bytes);
    }
}