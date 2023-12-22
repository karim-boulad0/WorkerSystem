<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'worker_id',
        'content',
        'price',
        'rejected_reason',
        'status',
    ];
    public function photos()
    {
        return $this->hasMany(PostPhoto::class);
    }
    public function Worker()
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }
    public function reviews()
    {
        return $this->hasMany(WorkerReview::class);
    }
}
