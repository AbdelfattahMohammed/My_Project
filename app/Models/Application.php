<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = ['job_id','candidate_id','resume','cover_letter','status','applied_at',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function Posting()
    {
        return $this->belongsTo(Posting::class, 'job_id', 'id');
    }
}

