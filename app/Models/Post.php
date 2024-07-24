<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['blog_id', 'title',  'content', 'cover_image_url'];

    public function blog(){

        return $this->belongsTo(Blog::class);

    }
    public function comments(){

        return $this->hasMany(Comment::class);

    }

    public function likes(){

        return $this->hasMany(Like::class);
        
    }
}
