<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Tag\IndexRequest;
use App\Http\Requests\Api\Tag\StoreRequest;
use App\Http\Requests\Api\Tag\UpdateRequest;
use App\Http\Resources\Tag\ImageResource;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\Response;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request)
    {
        $data = $request->validated();
        $tags = Tag::filter($data)->get();
        return ImageResource::make($tags)->resolve();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $tag = TagService::create($data);
        return ImageResource::make($tag)->resolve();
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        return ImageResource::make($tag)->resolve();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Tag $tag)
    {
        $data = $request->validated();
        $tag = TagService::update($tag, $data);
        return ImageResource::make($tag)->resolve();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        TagService::delete($tag);
        return response()->json([
            'message' => 'Tag deleted'
        ], Response::HTTP_OK);
    }
}
