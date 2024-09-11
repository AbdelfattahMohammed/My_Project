<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Employer extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['user_id','company_name','company_logo','company_description','website','contact_info',
    ];

    /**
     * Get the user that owns the employer.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function posting()
    {
        return $this->hasMany(Posting::class, 'employer_id');
    }
}
