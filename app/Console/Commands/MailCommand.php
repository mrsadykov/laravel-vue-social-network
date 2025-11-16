<?php

namespace App\Console\Commands;

use App\Jobs\SomeJob;
use App\Models\Post;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\Comment\StoredCommentMail;

class MailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        SomeJob::dispatch();
        //$user = User::find(1);
        //$post = Post::find(1);
        //Mail::to($user)->send(new StoredCommentMail($post));
    }
}
