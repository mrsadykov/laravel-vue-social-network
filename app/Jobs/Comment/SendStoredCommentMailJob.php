<?php

namespace App\Jobs\Comment;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Mail;
use App\Mail\Comment\StoredCommentMail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendStoredCommentMailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Post $post,
        public Comment $comment
    )
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // отправить email автору поста
        Mail::to($this->post->profile->user)->send(new StoredCommentMail($this->post, $this->comment));
    }
}
