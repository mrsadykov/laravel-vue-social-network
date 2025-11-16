<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\IndexRequest;
use App\Http\Requests\Admin\Post\StoreRequest;
use App\Http\Requests\Admin\Post\UpdateRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\Tag\TagResource;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Services\PostService;
use App\Services\TagService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

class PostController extends Controller
{
    public function index(IndexRequest $request)
    {
        // $request->validated() возвращает конечные данные, которые прошли валидацию,
        // тогда как $request->validationData() предоставляет данные,
        // которые будут проверены на соответствие правилам валидации
        //$data = $request->validated();
        $data = $request->validationData();

        // кеширование (драйвер: database, то есть кеш хранится в бд)
        $key = md5(json_encode($data));
        $posts = Cache::remember($key, now()->addMinutes(120), function() use ($data) {
            return Post::filter($data)->latest()->paginate(
                $data['per_page'],
                '*',
                'page',
                $data['page']
            );
        });

        //$posts = Post::latest()->get();
        // без пагинации
        // $posts = Post::filter($data)->latest()->get();

        // с пагинацией
        // $posts = Post::filter($data)->latest()->paginate(
        //     $data['per_page'],
        //     '*',
        //     'page',
        //     $data['page']
        // );

        // c resolve() возращается только массив (в том числе пагинация пропадает)
        // $posts = PostResource::collection($posts)->resolve();
        $posts = PostResource::collection($posts);

        // axios всегда ждет json
        if (Request::wantsJson())
            return $posts;

        return inertia('Admin/Post/Index', compact('posts'));
    }

    public function show(Post $post)
    {
        //dd($post);
        $post = PostResource::make($post)->resolve();
        //dd($post);
        return inertia('Admin/Post/Show', compact('post'));
    }

    public function create()
    {
        $categories = Category::all();
        $categories = CategoryResource::collection($categories)->resolve();

        return inertia('Admin/Post/Create', compact('categories'));
    }

    public function store(StoreRequest $request)
    {
        // позволяет получить все входные данные пользователя, кроме указанных (images)
        $data = $request->except('images');
        $post = PostService::store($data);
        $post = PostResource::make($post)->resolve();

        // сброс кеша
        Cache::flush();

        return $post;
    }

    public function edit(Post $post)
    {
        $post = PostResource::make($post)->resolve();

        $categories = Category::all();
        $categories = CategoryResource::collection($categories)->resolve();

        //$tags = Tag::all();
        //$tags = TagResource::collection($tags)->resolve();

        // Выбранные теги - строка
        $tags = TagService::getSelectedTags($post['tags']);

        //dd($post, $categories, $tags);

        return inertia('Admin/Post/Edit', compact(
            'post',
            'categories',
            'tags',
        ));
    }

    public function update(Post $post, UpdateRequest $request)
    {
        // получаем все кроме images
        $data = $request->except('images');
        $post = PostService::update($post, $data);
        $post = PostResource::make($post)->resolve();

        // сброс кеша
        Cache::flush();

        return $post;
    }

    public function destroy(Post $post)
    {
        PostService::delete($post);
        return response()->json([
           'message' => 'Статья успешно удалена',
        ], Response::HTTP_OK);
    }

    public function toggleLike(Post $post)
    {
        // 1 вариант
        // если есть строка в таблице, то добавляем, иначе удаляем
        /*$res = $post->likedByProfiles()->toggle(auth()->user()->profile->id);
        $post->fresh();
        return response()->json([
            'is_liked' => count($res['attached']) > 0,
            'liked_by_profiles_count' => $post->fresh()->liked_by_profiles_count
        ]);*/

        // 2 вариант
        $post->likedByProfiles()->toggle(auth()->user()->profile->id);

        // сброс кеша
        Cache::flush();

        return PostResource::make($post->fresh())->resolve();
    }
}
