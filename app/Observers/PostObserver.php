<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        logModelChange(__FUNCTION__, $post);
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        logModelChange(__FUNCTION__, $post);
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        logModelChange(__FUNCTION__, $post);
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        logModelChange(__FUNCTION__, $post);
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        logModelChange(__FUNCTION__, $post);
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function retrieved(Post $post): void
    {
        logModelChange(__FUNCTION__, $post);
    }
}
