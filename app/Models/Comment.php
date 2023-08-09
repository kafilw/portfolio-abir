<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function photo()
    {
        return $this->belongsTo(Photos::class, 'photo_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
