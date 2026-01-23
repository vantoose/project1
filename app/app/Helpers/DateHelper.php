<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
	public static function diffForHumans($value, $locale = "")
	{
		if ($value == null) return $value;
    	$locale = $locale ?: app()->getLocale();
		return Carbon::parse($value)->locale($locale)->diffForHumans();
  	}

	public static function isoFormat($value, $format = "Do MMMM Y", $locale = "")
	{
		if ($value == null) return $value;
    	$locale = $locale ?: app()->getLocale();
		return Carbon::parse($value)->locale($locale)->isoFormat($format);
  	}

	public static function dateString($value, $locale = "")
	{
		if ($value == null) return $value;
    	$locale = $locale ?: app()->getLocale();
		return Carbon::parse($value)->locale($locale)->toDateString();
	}

	public static function timeString($value, $locale = "")
	{
		if ($value == null) return $value;
    	$locale = $locale ?: app()->getLocale();
		return Carbon::parse($value)->locale($locale)->toTimeString();
  	}
}
