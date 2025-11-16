<?php

namespace App\Console\Commands;

use App\Events\Post\StoredPostEvent;
use App\Events\WS\Message\SendMessageEvent;
use App\Events\WS\Post\CommentStoredEvent;
use App\Models\Tag;
use App\Models\Chat;
use App\Models\Post;
use App\Models\User;
use App\Models\Image;
use App\Models\Comment;
use App\Models\Message;
use App\Models\Profile;
use App\Models\Category;
use App\Models\Role;
use App\Models\UserNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

class GoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'go';

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
        // Category
        //$category = Category::query()->find(1);
        //dd($category->posts->toArray());

        // Chat
        //$chat = Chat::query()->find(4);
        //dd($chat->profile->toArray());

        // Comment
        //$comment = Comment::query()->find(1);
        //dd($comment->profile->toArray(), $comment->post->toArray());

        // Message
        //$message = Message::query()->find(1);
        //dd($message->chat->toArray(), $message->profile->toArray());

        // Post
        /*$post = Post::query()->find(5);
        dd([
            'profile' => $post->profile?->toArray(),
            'tags' => $post->tags?->toArray(),
            'category' => $post->category?->toArray(),
            'likedByProfiles' => $post->likedByProfiles?->toArray(),
            'viewedByProfile' => $post->viewedByProfile?->toArray(),
            'repost(parent_id)' => $post->repost?->toArray(),
            'comments' => $post->comments?->toArray()
        ]);*/

        // Profile
        // Role
        // Tag
        // User

        /*$user = User::first();
        $user->profile()->create([ 'login' => 'tttt' ]);*/

        //dd($user->profile->toArray());

        // $post = Post::find(4);
        // $tag = Tag::first();
        // $tag2 = Tag::find(2);
        // $tag3 = Tag::find(3);
        // $tag4 = Tag::find(4);

        // пивотные методы many many
        // attach - только для создания связи
        //$post->tags()->attach($tag->id); // присоединяем теги к посту
        //$post->tags()->attach($tag); // присоединяем теги к посту

        // detach - удаление связи
        //$post->tags()->detach($tag);

        // sync - оставляет указанные связи, остальные удаляет
        //$post->tags()->sync([ $tag, $tag3 ]);

        // syncWithoutDetaching
        //$post->tags()->syncWithoutDetaching($tag4);

        // toggle - если есть связь, то удалит, если нет, то создаст
        //$post->tags()->toggle($tag4);

        // updateExistingPivot - обновляет дополнительный атрибут в пивот таблице
        /*$post->tags()->updateExistingPivot($tag->id, [
            // нужно создать поле статус в пивот таблице
            'status' => 2
        ]);*/

        // отношения 1 ко многим через
        //$category = Category::query()->find(10);
        //dd($category->posts->toArray(), $category->comments->toArray());

        //$comment = Comment::first();
        //dd($comment->category?->toArray());

        //$post = Post::first();
        //dd($post->likedByProfiles->toArray());

        //$user = User::find(6);
        //dd($user->toArray());
        //dd($user->profile->toArray());
        //dd($user->chats->toArray());
        //dd($user->comments->toArray());
        //dd($user->messages->toArray());

        /*$profile = Profile::first();
        $profile->image()->create([
            'path' => 'test/123.jpg'
        ]);
        dd($profile->image);*/

        //$image = Image::first();
        //dd($image->imageable);

        // $post = Post::first();
        // $post->comments()->create([
        //     'content' => '555asdasd',
        //     'published_at' => '2025-01-01',
        //     'profile_id' => 1
        // ]);
        //dd($post->id);

        //$comment = Comment::first();
        //dd($comment->commentable);

        // многие ко многим (полиморфные)
        // комментарии - посты - лайки
        // удалить таблицу post_profile_likes

        // создаем пивотную полиморфную таблицу likeables_table
        // profile полиморф потому что может лайкать и комментарий и пост
        // posts  ------- comments
        //
        // pivot
        // profile_id
        // likeable_id
        // likeable_type
        //
        // profiles


        // так лайкаются посты и комментарии
        //$profile = Profile::first();
        //$post = Post::first();
        /*$profile->likedPosts()->attach($post->id);
        //dd($profile->likedPosts->toArray());*/

        //$comment = Comment::first();
        //$profile->likedComments()->attach($comment->id);
        //dd($profile->likedComments->toArray());

        //dd($post->likedByProfiles->toArray());


        // миграции

        // 1. create_... (по умолчанию миграция)
        // 2. add_migration_... (добавление полей без индексов и внешний ключей)
        // 3. add_migration_... (добавление 2-x лишних полей)
        // 4. add_column_... (добавление колонки с некорректным типом)
        // 5. add_index_... (добавление индекса или индексов) + изменение уже созданного поля в индекс
        // 6. add_fk_... (добавление внешних ключей)
        // 7. drop_column(s)_... (удаление ненужные поля)
        // 8. change_column_... (изменить некорректные атрибуты в нужный тип)
        // 9. add_soft_deletes_... (добавление soft_deletes)

        /*Post::query()->create([
            'title' => 'some title 11:21',
            'content' => 'asdasd sdfk;smdkmv mksdmflsdmlf mdsa1121',
            'profile_id' => 1
        ]);*/

        /*$post = Post::query()->find(41);
        $post->update([
            'title' => 'some title 22:41',
            'content' => 'kjnfsddj nsdfnsdkfn 22:41'
        ]);*/

        //$post = Post::query()->withTrashed()->find(41);
        //$post->restore();
        //dd($post->toArray());
        //$post->delete();

        //$post = Post::query()->find(30);
        //$post->forceDelete();

        /*User::query()->create([
            'name' => 'John',
            'email' => 'test111@mail.ru',
            'password' => Hash::make('password')
        ]);*/

        /*Category::query()->create([
            'title' => 'some title dfgfdasdas asdas'
        ]);*/

        //$post = Post::factory()->create();
        // выполнение event
        //StoredPostEvent::dispatch($post);

        //Category::factory()->create();

        //$post = Post::factory()->create();
        //Log::channel('post')->info('post was created with id: {id}', [ 'id' => $post->id ]);

        //Category::factory()->create();
        //Role::factory()->create();

        //$post = Post::find(1);
        //dd($post);
        //$post->update([ 'title' => 1234 ]);

        /*User::query()->create([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'test'
        ]);*/

        /*$posts = DB::table("posts")->select('title')->get();
        //$posts = Post::all('title');
        $posts = DB::table("posts")->insert([
            'title' => '123ttt',
            'content' => '123ttt desc',
            'profile_id' => 1
        ]);

        dd($posts);*/

        // прослушка взаимодействия с бд
        /*DB::listen(function ($query) {
           dump($query->time);
           dump($query->sql);
           dump($query->bindings);
           dump($query->connectionName);
           dump($query->toRawSql());
        });*/

        //$post = Post::first();

        // получить пользователей и их профили
        /*$users = DB::table('profiles')
            ->leftJoin('users', 'profiles.user_id', '=', 'users.id')
            ->leftJoin('posts', 'profiles.id', '=', 'posts.profile_id')
            ->select('users.id', 'users.name', 'profiles.login', 'posts')
            //->where('profiles.user_id', '=', 1)
            ->get();

        dd($users->toArray());*/

        /*$user2 = User::create([
            'name' => 'user2',
            'email' => 'user2@mail.com',
            'password' => 'user2'
        ]);

        $user2->profile()->create([
            'login' => 'user2'
        ]);*/

        //dd(auth()->user()->profile);
        //dd(auth()->user()->profile->chats()->create());

        /*$profileIds = [ 1, 8 ];

        // идентификаторы чатов, в которых столько же пользователей сколь в $profileIds
        $chatIds = DB::table('chat_profile')
            ->select('chat_id')
            // идентификаторы чатов, в которых есть текущие профили
            ->whereIn('chat_id', function($query) use ($profileIds) {
                $query
                    ->select('chat_id')
                    ->from('chat_profile')
                    ->whereIn('profile_id', $profileIds)
                    ->groupBy('chat_id')
                    ->havingRaw('COUNT(DISTINCT profile_id) = ?', [count($profileIds)]);
            })
            ->groupBy('chat_id')
            ->havingRaw('COUNT(*) = ?', [ count($profileIds) ])
            ->get()
            ->pluck('chat_id')
            ->toArray();

        dd(
            $chatIds
        );*/

        // $res = DB::table('chat_profile')
        //     ->whereHas('profiles', function($query) {
        //         //$query->
        //     });

        // $res = UserNotification::create([
        //     'content' => 'sdfas',
        //     'profile_id' => 1
        // ]);

        //dd($res);

//        UserNotification::query()
//            ->update([
//                'read_at' => null
//            ]);

        //SendMessageEvent::dispatch([ 'test' => 123, 'chat_id' => 123 ]);
        /*CommentStoredEvent::dispatch(
            [
                'profile_id' => 1
            ],
            [
                456
            ]
        );*/


    }
}
