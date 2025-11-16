<?php

namespace App\Http\Resources\Chat;

use App\Http\Resources\Message\MessageResource;
use App\Http\Resources\Profile\ProfileCollection;
use App\Http\Resources\Profile\ProfileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $profiles = ProfileResource::collection($this->profiles()->with([
            'user',
            'notifications',
            'followers',
            'followings',
            //'viewedPosts',
            //'image',
            //'likedPosts',
            //'likedComments',
            //'chats'
        ])->get())->resolve();

        if (empty($this->title)) {
            $logins = [];
            $currentUserProfileId = auth()->user()->profile->id;
            foreach ($profiles as $profile) {
                if ($profile['id'] !== $currentUserProfileId) {
                    $logins[] = $profile['login'];
                }
            }

            if (!empty($logins)) {
                $loginsStr = implode(',', $logins);
                if (strlen($loginsStr) > 0) {
                    $title = 'Chat with ' . $loginsStr;
                }
            }
        }

        return [
            'id' => $this->id,
            'profile_id' => $this->profile_id,
            'title' => $title ?? $this->title,
            'profiles' => $profiles,
        ];
    }
}
