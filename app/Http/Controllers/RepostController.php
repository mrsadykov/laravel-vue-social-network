<?php

namespace App\Http\Controllers;

use App\Http\Resources\Repost\RepostResource;
use App\Models\Repost;

class RepostController extends Controller
{
    public function index()
    {
        return RepostResource::collection(Repost::all())->resolve();
    }

    public function show(Repost $repost)
    {
        return RepostResource::make($repost)->resolve();
    }

    public function store()
    {
        $data = [
            'post' => 55,
            'author' => 'Iskandar',
        ];

        $repost = Repost::query()->create($data);
        return RepostResource::make($repost)->resolve();
    }

    public function update(Repost $repost)
    {
        $data = [
            'post' => 55,
            'author' => 'Iskandar edited ' . md5(now()),
        ];

        $repost->update($data);
        return RepostResource::make($repost)->resolve();
    }

    public function destroy(Repost $repost)
    {
        $repost->delete();
        return response([
            'message' => 'Repost deleted'
        ]);
    }
}
