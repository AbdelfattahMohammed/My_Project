<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PostAction extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'posting_id', 'action_type', 'comment_text', 'platform'];

    public function posting()
    {
        return $this->belongsTo(Posting::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
