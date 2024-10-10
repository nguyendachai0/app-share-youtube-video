<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    public $fillable = ['user_id', 'title', 'description', 'video_url',  'thumbnail_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function activeLikes()
    {
        return $this->hasMany(Like::class)->where('active', true);
    }
}
