<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Memo extends Model
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
	public function scopeOrdered(Builder $query)
	{
		$query->orderByRaw('CASE WHEN deleted_at IS NOT NULL THEN TRUE ELSE FALSE END, deleted_at DESC')
		->orderByDesc('updated_at')
		->orderByDesc('created_at')
		->orderByDesc('id');
	}

    /**
     * Scope для поиска по содержимому
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (!$search) return $query;
        return $query->where(function(Builder $q) use ($search) {
            $q->where('content', 'like', "%{$search}%");
        });
    }
}
