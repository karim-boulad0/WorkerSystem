<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostPhoto extends Model
{
    use HasFactory;
    protected $fillable = ['post_id', 'photo'];
    function Post(){
        return $this->belongsTo(Post::class,'post_id');

    }
}
