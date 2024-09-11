<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Candidate extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['user_id','resume','skills','experience_level','location','contact_info',
    ];

    /**
     * Get the user that owns the candidate.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // public function notification()
    // {
    //     return $this->belongsTo(Notification::class);
    // }
}
