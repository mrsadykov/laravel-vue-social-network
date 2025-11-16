<?php

namespace App\Http\Controllers;

use App\Http\Resources\Tag\ImageResource;
use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        return ImageResource::collection(Tag::all())->resolve();
    }

    public function show(Tag $tag)
    {
        return ImageResource::make($tag)->resolve();
    }

    public function store()
    {
        $data = [
            'title' => 'Lorem ipsum ' . md5(now()),
        ];

        $tag = Tag::query()->create($data);
        return ImageResource::make($tag)->resolve();
    }

    public function update(Tag $tag)
    {
        $data = [
            'title' => 'Edited Lorem ipsum ' . md5(now()),
        ];

        $tag = $tag->update($data);
        return ImageResource::make($tag)->resolve();
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response([
            'message' => 'Tag deleted'
        ]);
    }
}
