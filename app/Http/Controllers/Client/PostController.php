<?php

namespace App\Http\Controllers\Client;

use App\Events\Comment\CommentAnswerStored;
use App\Events\Comment\CommentLiked;
use App\Events\Comment\CommentStored;
use App\Mapper\PostMapper;
use App\Models\Post;
use App\Models\Comment;
use App\Http\Controllers\Controller;
use App\Models\UserNotification;
use App\Services\UserNotificationService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Mail\Comment\StoredCommentMail;
use Illuminate\Support\Facades\Request;
use App\Http\Resources\Post\PostResource;
use App\Http\Requests\Client\Post\IndexRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Requests\Client\Post\IndexCommentRequest;
use App\Http\Requests\Client\Post\StoreCommentRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use App\Events\WS\Post\CommentStoredEvent as WsCommentStored;

class PostController extends Controller
{
    public function Show(Post $post) {
        // мэппер там где используется больше 1 модели
        return inertia('Client/Post/Show', PostMapper::show($post));
    }

    public function destroy(Post $post)
    {
        //dd($post->toArray());

        // связано с политикой, а политика - это проверка действий (как мидлвейер, но роут ограничения на роуты)
        Gate::authorize('delete', $post);
        // лучше через сервис
        $post->delete();
        return response()->json([
            'message' => 'Статья успешно удалена',
        ], Response::HTTP_OK);
    }

    public function storeComment(Post $post, StoreCommentRequest $request)
    {
        $data = $request->validated();

        $comment = $post->comments()->create($data);

        // очистка кешей комментариев постов
        $this->clearPostCommentsCache($post);

        if (isset($data['parent_comment_id']) && !empty($data['parent_comment_id'])) {
            // бросаем событие - отправка email автору комментария
            $parentComment = Comment::find($data['parent_comment_id']);
            CommentAnswerStored::dispatch($parentComment, $comment);
        } else {
            // бросаем событие - отправка email автору поста
            CommentStored::dispatch($post, $comment);
        }

        // добавление напоминания
        // 1. написать сервис UserNotificationService - создать напоминание
        // 2. написать ресурс для UserNotification
        // в событии отправить ресурс UserNotification
        //UserNotification::create();

        //dd($comment);

        UserNotificationService::store($comment);

        //dd(PostResource::make($post)->resolve());

        // выбрасывания события
        WsCommentStored::broadcast(
            //'Новый комментарий к посту с id ' . $post->id,
            PostResource::make($post)->resolve()
        );

        return CommentResource::make($comment)->resolve();
    }

    public function toggleCommentLike(Post $post, Comment $comment)
    {
        $comment->likedByProfiles()->toggle(auth()->user()->profile->id);

        // очистка кешей комментариев постов
        $this->clearPostCommentsCache($post);

        $commentObj = $comment;
        $comment = CommentResource::make($comment->fresh())->resolve();

        if ($comment['is_liked']) {
            CommentLiked::dispatch($commentObj);
        }

        return $comment;
    }

    public function IndexComment(Post $post, IndexCommentRequest $request)
    {
        $data = $request->validationData();

        // Создаем уникальный ключ, включающий ID поста, номер страницы и количество элементов на странице
        $key = "comments_post_{$post->id}_page_{$data['page']}_per_page_{$data['per_page']}";

        $comments = Cache::get($key);

        if (!$comments) {
            $comments = $post
                ->comments()
                ->latest()
                ->where('parent_comment_id', null)
                ->paginate(
                    $data['per_page'],
                    '*',
                    'page',
                    $data['page']
                );

            Cache::put($key, $comments, now()->addMinutes(120));
        }

        return CommentResource::collection($comments);
    }

    public function clearPostCommentsCache(Post $post)
    {
        for ($page = 1; $page <= 100; $page++) { // страницы от 1 до 100
            for ($perPage = 2; $perPage <= 100; $perPage++) { // количество комментов на странице от 2 до 100
                $key = "comments_post_{$post->id}_page_{$page}_per_page_{$perPage}";
                Cache::forget($key);
            }
        }
    }

    public function destroyComment(Post $post, Comment $comment)
    {
        //dd($post, $comment);

        Gate::authorize('delete', $comment);

        $comment->delete();
        $this->clearPostCommentsCache($post);

        return response()->json([
            'message' => 'Коммент успешно удален',
        ], Response::HTTP_OK);
    }
}
