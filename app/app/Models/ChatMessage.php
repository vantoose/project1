<?php

namespace App\Models;

use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'chat_room_id',
        'user_id',
    ];

	protected $appends = [
        'datetime',
		'username',
	];

	public function getDatetimeAttribute()
	{
		return DateHelper::isoFormat($this->updated_at, "DD.MM.YYYY hh:mm:ss");
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