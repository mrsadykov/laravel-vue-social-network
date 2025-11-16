<?php

namespace App\Jobs\Comment;

use App\Models\Comment;
use Illuminate\Support\Facades\Mail;
use App\Mail\Comment\LikedCommentMail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCommentLikeMailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Comment $comment
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->comment->profile->user)
            ->send(new LikedCommentMail($this->comment));
    }
}
