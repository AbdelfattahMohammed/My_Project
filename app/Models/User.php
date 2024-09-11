<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','email','password','role','profile_picture',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password','remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['email_verified_at' => 'datetime',
    ];
    public function employer()
    {
        return $this->hasOne(Employer::class);
    }
    public function posting()
    {
        return $this->hasMany(Posting::class);
    }
    public function postActions()
    {
        return $this->hasMany(PostAction::class);
    }
    public function candidates()
    {
        return $this->hasOne(Candidate::class);
    }
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }
    public function application()
    {
        return $this->hasMany(Application::class);
    }

    
    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }


    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
