<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientOrder extends Model
{
    use HasFactory;
    protected $fillable = ['client_id', 'post_id'];
    protected $guard = ['status'];
    public function Client()
    {
        return $this->BelongsTo(Client::class, 'client_id')->select('id', 'name');
    }
    public function Post()
    {
        return $this->BelongsTo(Post::class, 'post_id')->select('id', 'content');
    }
}
