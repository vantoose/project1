<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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
        'published_at' => 'datetime', // Casts to Carbon instance with time
		'options' => 'array',
	];

	/**
	 * Is published.
	 *
	 * @return string
	 */
	public function getIsPublishedAttribute()
	{
		return $this->published_at !== null;
	}

	/**
	 * Get the user that owns the entity.
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * Scope a query to published entities.
	 *
	 * @param  \Illuminate\Database\Eloquent\Builder  $query
	 * @return void
	 */
	public function scopePublished($query)
	{
		$query->whereNotNull('published_at');
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
		->orderByDesc('published_at')
		->orderByDesc('updated_at')
		->orderByDesc('created_at')
		->orderByDesc('id');
	}

    /**
     * Scope для поиска по заголовку и содержимому
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (!$search) return $query;
        return $query->where(function(Builder $q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
            ->orWhere('content', 'like', "%{$search}%");
        });
    }
}
