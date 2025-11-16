<?php

namespace App\Services;

use App\Models\Profile;

class ProfileService
{
    public static function create($data)
    {
        return Profile::query()->create($data);
    }

    public static function update(Profile $profile, array $data)
    {
        $profile->update($data);
        return $profile;
    }

    public static function delete(Profile $profile)
    {
        $profile->delete();
        return $profile;
    }
}
