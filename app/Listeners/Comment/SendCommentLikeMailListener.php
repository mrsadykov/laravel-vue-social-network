<?php

namespace App\Listeners\Comment;

use App\Events\Comment\CommentLiked;
use App\Jobs\Comment\SendCommentLikeMailJob;
use Illuminate\Support\Facades\Mail;
use App\Mail\Comment\LikedCommentMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCommentLikeMailListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CommentLiked $event): void
    {
        $comment = $event->comment;

        SendCommentLikeMailJob::dispatch($comment);
    }
}
