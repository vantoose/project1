<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
	use SoftDeletes;

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
}
