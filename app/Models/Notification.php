<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    public $incrementing = false; // Disable auto-incrementing

    protected $keyType = 'string'; // Set key type to string for UUIDs

    protected $table = 'notifications';

    protected $fillable = [
        'id',
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the parent notifiable model (user or other model).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'notifiable_id');
    }
    // public function candidates()
    // {
    //     return $this->hasMany(Candidate::class);
    // }
}


