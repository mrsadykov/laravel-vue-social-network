<?php

namespace App\Jobs\Comment;

use App\Models\Comment;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\Comment\StoredCommentAnswerMail;

class SendStoredCommentAnswerMailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Comment $parentComment,
        public Comment $comment,
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->parentComment->profile->user)
            ->send(new StoredCommentAnswerMail($this->parentComment, $this->comment));
    }
}
