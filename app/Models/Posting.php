<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posting extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'title',
        'description',
        'responsibilities',
        'required_skills',
        'qualifications',
        'salary_range',
        'benefits',
        'location',
        'work_type',
        'application_deadline',
        'status',
        'posted_at',
        'image',
    ];

    protected $casts = ['posted_at' => 'datetime'];

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function postActions()
    {
        return $this->hasMany(PostAction::class);
    }
    public function applications()
    {
        return $this->hasMany(Application::class, 'job_id', 'id');
    }
}
