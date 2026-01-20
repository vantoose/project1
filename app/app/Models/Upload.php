<?php

namespace App\Models;

use App\Helpers\FileHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Upload extends Model
{
	use SoftDeletes;
	
	/**
	 * The "booted" method of the model.
	 *
	 * @return void
	 */
	protected static function booted()
	{
		static::deleting(function ($upload) {
			Storage::delete($upload->path);
		});
	}

	/**
	 * The attributes that should be cast.
	 *
	 * @var array
	 */
	protected $casts = [
		'options' => 'array',
	];
	
	/**
	 * Get the user that owns the entity.
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}
	
	/**
	 * The accessors to append to the model's array form.
	 *
	 * @var array
	 */
	protected $appends = [
		'dirname',
		'extension',
		'lastModified',
		'absolutePath',
		'size',
		'url'
	];

	/**
	 * Get the directory name of the file.
	 *
	 * @return string
	 */
	public function getDirnameAttribute()
	{
		$path = Storage::path($this->path);
		return pathinfo($path, PATHINFO_DIRNAME);
	}

	/**
	 * Get the file extension of the file.
	 *
	 * @return string
	 */
	public function getExtensionAttribute()
	{
		$path = Storage::path($this->path);
		return pathinfo($path, PATHINFO_EXTENSION);
	}

	/**
	 * Get the UNIX timestamp of the last time the file was modified.
	 *
	 * @return string
	 */
	public function getLastModifiedAttribute()
	{
		return Storage::lastModified($this->path);
	}

	/**
	 * Get the absolute path to the file.
	 *
	 * @return string
	 */
	public function getAbsolutePathAttribute()
	{
		return Storage::path($this->path);
	}

	/**
	 * Get the size of a file in bytes.
	 *
	 * @return string
	 */
	public function getSizeAttribute()
	{
		return Storage::size($this->path);
	}

	/**
	 * Get the relative URL to the file.
	 *
	 * @return string
	 */
	public function getUrlAttribute()
	{
		return Storage::url($this->path);
	}

	/**
	 * Scope a query to ordered entities.
	 *
	 * @param  \Illuminate\Database\Eloquent\Builder  $query
	 * @return void
	 */
	public function scopeOrdered($query)
	{
		$query->orderByRaw('CASE WHEN deleted_at IS NOT NULL THEN TRUE ELSE FALSE END, deleted_at DESC')
		->orderByDesc('updated_at')
		->orderByDesc('created_at')
		->orderByDesc('id');
	}

	/**
	 * Upload a file.
	 * 
	 * @return App\Models\Upload
	 */
	static function upload_file(UploadedFile $file, Array $attributes, String $dir = "common")
	{
		$name = $file->getClientOriginalName();
		$name = pathinfo($name, PATHINFO_FILENAME);
		$path = $file->store("uploads/files/$dir");
		$upload = new Upload;
		$upload->path = $path;
		$upload->name = $name;
		$upload->options = $attributes['options'];
		$upload->user_id = $attributes['user_id'];
		$upload->save();
		return $upload;
	}

	/**
	 * Download the file.
	 * 
	 * @return ???
	 */
	public function download()
	{
	 return Storage::download($this->path, $this->name . '.' . $this->extension);
	}
}
