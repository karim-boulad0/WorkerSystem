<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
    /**
     * Handle the Post "creating" event.
     */
    public function creating(Post $post): void
    {
        $post->status  = 'pending';
    }
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
    }

    /**
     * Handle the post "updated" event.
     */
    public function updated(Post $post): void
    {
        //
    }

    /**
     * Handle the post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        //
    }

    /**
     * Handle the post "restored" event.
     */
    public function restored(Post $post): void
    {
        //
    }

    /**
     * Handle the post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        //
    }
}
