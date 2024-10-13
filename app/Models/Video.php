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

    public function likesByType($type)
    {
        return $this->hasMany(Like::class)->where('type', $type)->where('active', true);
    }

    public function likeCount()
    {
        return $this->likesByType('like')->count();
    }

    public function dislikeCount()
    {
        return $this->likesByType('dislike')->count();
    }
}
