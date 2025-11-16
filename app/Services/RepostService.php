<?php

namespace App\Services;

use App\Models\Repost;

class RepostService
{
    public static function create($data)
    {
        return Repost::query()->create($data);
    }

    public static function update(Repost $repost, array $data)
    {
        $repost->update($data);
        return $repost;
    }

    public static function delete(Repost $repost)
    {
        $repost->delete();
        return $repost;
    }
}
