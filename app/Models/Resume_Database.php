<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumeDatabase extends Model
{
    use HasFactory;

    protected $fillable = ['employer_id','candidate_id','search_criteria','search_date',
    ];

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}

