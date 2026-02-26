<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
	use SoftDeletes;
	use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	/**
	 * Get total size of uploaded files in bytes.
	 *
	 * @return string
	 */
	public function getUploadsTotalSizeAttribute()
	{
        return $this->uploads->pluck('size')->sum();
	}

    /**
     * Генерация нового API токена
     *
     * @return string
     */
    public function generateApiToken()
    {
        $token = Str::random(60);
        $this->api_token = hash('sha256', $token);
        $this->save();
        
        return $token;
    }

    /**
     * Удаление API токена
     *
     * @return void
     */
    public function clearApiToken()
    {
        $this->api_token = null;
        $this->save();
    }

    /**
     * Проверка, имеет ли пользователь валидный токен
     *
     * @return bool
     */
    public function hasValidApiToken()
    {
        return !empty($this->api_token);
    }
	
	/**
	 * Get the user's memos.
	 */
	public function memos()
	{
		return $this->hasMany(Memo::class);
	}
	
	/**
	 * Get the user's posts.
	 */
	public function posts()
	{
		return $this->hasMany(Post::class);
	}
	
	/**
	 * Get the user's uploads.
	 */
	public function uploads()
	{
		return $this->hasMany(Upload::class);
	}
	
	/**
	 * Get the user's chat messages.
	 */
    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }
	
	/**
	 * Get the user's chat rooms.
	 */
    public function chatRooms()
    {
        return $this->belongsToMany(ChatRoom::class, 'chat_room_user');
    }
}
