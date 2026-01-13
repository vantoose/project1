<?php

namespace App\Helpers;

use Carbon\Carbon;

class FileHelper
{
  public static function formatSizeUnits($bytes)
  {
    if ($bytes >= 1073741824)
    {
      $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576)
    {
      $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif ($bytes >= 1024)
    {
      $bytes = number_format($bytes / 1024, 2) . ' KB';
    }
    elseif ($bytes > 1)
    {
      $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
      $bytes = $bytes . ' byte';
    }
    else
    {
      $bytes = '0 bytes';
    }
    return $bytes;
  }

  public static function isImage($file)
  {
    $whitelist_type = array('image/jpeg', 'image/png', 'image/gif');
    if (function_exists('finfo_open')) { // (PHP >= 5.3.0, PECL fileinfo >= 0.1.0)
      $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
      if (in_array(finfo_file($fileinfo, $file), $whitelist_type)) {
        return true;
      }
    } else if (function_exists('mime_content_type')) { // supported (PHP 4 >= 4.3.0, PHP 5)
      if (in_array(mime_content_type($file), $whitelist_type)) {
        return true;
      }
    }
    if (@getimagesize($file)) { // @ - for hide warning when image not valid
      return true;
    }
    return false;
  }
}
