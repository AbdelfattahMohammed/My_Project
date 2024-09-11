<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSearch extends Model
{
    use HasFactory;

    protected $fillable = ['candidate_id','keywords','location','category','experience_level','salary_range','date_posted','search_date',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}

