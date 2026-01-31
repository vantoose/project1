<?php

namespace App\Models;

use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatMessage extends Model
{
	use SoftDeletes;

    protected $fillable = [
        'message',
        'chat_room_id',
        'user_id',
    ];
    
	/**
	 * The attributes that should be cast.
	 *
	 * @var array
	 */
	protected $casts = [
		'options' => 'array',
	];

	protected $appends = [
        'date',
        'time',
		'username',
	];

	public function getDateAttribute()
	{
		return DateHelper::isoFormat($this->created_at, "DD.MM.YYYY");
	}

	public function getTimeAttribute()
	{
		return DateHelper::isoFormat($this->created_at, "HH:mm:ss");
	}

	public function getUsernameAttribute()
	{
		$user = User::find($this->user_id);
		return $user->name;
	}

    public function room()
    {
        return $this->belongsTo(ChatRoom::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}