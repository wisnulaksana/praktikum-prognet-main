<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticable
{
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'username', 'password', 'email_verfied_at', 'profile_image', 'phone'
    ];

    protected $hidden = ['password'];

    public function getImageAttribute()
    {
        return $this->profile_image ? asset('storage/' . $this->profile_image) : asset('assets/images/default-user.jpg');
    }

    public function notifications()
    {
        return $this->morphMany(AdminNotification::class, 'notifiable')->orderBy('created_at', 'desc');
    }

    public function unreadNotifications()
    {
        return $this->morphMany(AdminNotification::class, 'notifiable')->where('read_at',null)
            ->orderBy('created_at', 'desc');
    }
}
