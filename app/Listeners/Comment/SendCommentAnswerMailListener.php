<?php

namespace App\Listeners\Comment;

use App\Events\Comment\CommentAnswerStored;
use App\Jobs\Comment\SendStoredCommentAnswerMailJob;
use App\Mail\Comment\StoredCommentAnswerMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendCommentAnswerMailListener
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
    public function handle(CommentAnswerStored $event): void
    {
        $parentComment = $event->parentComment;
        $comment = $event->comment;

        SendStoredCommentAnswerMailJob::dispatch($parentComment, $comment)->onQueue('emails');
    }
}
