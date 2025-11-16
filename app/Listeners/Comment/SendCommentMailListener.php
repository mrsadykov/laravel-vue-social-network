<?php

namespace App\Listeners\Comment;

use Illuminate\Support\Facades\Mail;
use App\Events\Comment\CommentStored;
use App\Jobs\Comment\SendStoredCommentMailJob;
use App\Mail\Comment\StoredCommentMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCommentMailListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     */
    public function handle(CommentStored $event): void
    {
        $post = $event->post;
        $comment = $event->comment;

        // заносим в очередь
        SendStoredCommentMailJob::dispatch($post, $comment)->onQueue('emails');
    }
}
