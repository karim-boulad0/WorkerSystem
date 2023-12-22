<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerReview extends Model
{
    use HasFactory;
    protected $fillable = ['post_id', 'client_id', 'comment', 'rate'];
    public function Client()
    {
        return $this->BelongsTo(Client::class, 'client_id')->select('id', 'name');
    }
    public function Post()
    {
        return $this->BelongsTo(Post::class, 'post_id')->select('id', 'content');
    }
}
