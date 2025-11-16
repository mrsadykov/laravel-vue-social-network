<?php

namespace App\Console\Commands;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Stat;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MakeStatCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make-stat';

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
        // количество всех комментариев
        $commentsCount = Comment::query()->count();

        // количество всех лайков
        $likesCount = DB::table('likeables')->count();

        // количество просмотров постов
        $postsViewsCount = DB::table('viewables')
            ->where('viewable_type', 'App\Models\Post')
            ->count();

        Stat::create([
            // количество всех статей
            'posts_count' => Post::query()->count(),

            // количество всех комментариев
            'comments_count' => $commentsCount,

            // количество всех лайков
            'likes_count' => $likesCount,

            // количество просмотров постов
            'posts_views_count' => $postsViewsCount,

            // отношение количества всех лайков к количеству просмотрам постов
            'likes_to_posts_views' => $likesCount / $postsViewsCount,

            // отношение количества всех лайков к количеству комментариям
            'likes_to_comments' => $likesCount / $commentsCount
        ]);
    }
}
