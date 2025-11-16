<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class PostCrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post-crud';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post CRUD command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // create
        $post = Post::query()->create([
            'title' => $this->ask('title'),
            'content' => $this->ask('content'),
        ]);

        // update
        $post->update([
            'author' => $this->ask('author')
        ]);

        // read
        $post = Post::query()->find($post->id);

        // delete
        $post->delete();

        dd($post);
    }
}
