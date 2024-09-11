<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Admin extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [ 'user_id','location','contact_info',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
