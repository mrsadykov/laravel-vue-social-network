<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tag\StoreRequest;
use App\Http\Resources\Tag\ImageResource;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        $tags = ImageResource::collection($tags)->resolve();
        return inertia('Admin/Tag/Index', compact('tags'));
    }

    public function show(Tag $tag)
    {
        $tag = ImageResource::make($tag)->resolve();
        return inertia('Admin/Tag/Show', compact('tag'));
    }

    public function create()
    {
        return inertia('Admin/Tag/Create');
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $tag = Tag::query()->create($data);
        $tag = ImageResource::make($tag)->resolve();
        return $tag;
    }
}
