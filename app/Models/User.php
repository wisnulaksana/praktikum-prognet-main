<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Reviews(){
        return $this->hasMany(ReviewProducts::class,'user_id');
    }

    public function transaction(){
        return $this->hasMany(Transactions::class,'user_id');
    }

    public function getImageAttribute()
    {
        return $this->profile_image ? asset('storage/' . $this->profile_image) : asset('assets/images/default-user.jpg');
    }
    public function notifications()
    {
        return $this->morphMany(UserNotification::class, 'notifiable')
            ->orderBy('created_at', 'desc');
    }

    public function unreadNotifications()
    {
        return $this->morphMany(UserNotification::class, 'notifiable')->where('read_at',null)
            ->orderBy('created_at', 'desc');
    }
    
}
