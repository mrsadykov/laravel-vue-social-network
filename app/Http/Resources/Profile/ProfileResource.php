<?php

namespace App\Http\Resources\Profile;

use App\Http\Resources\Notification\NotificationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'login' => $this->login,
            'second_name' => $this->second_name,
            'third_name' => $this->third_name,
            'avatar' => $this->avatar,
            'city' => $this->city,
            'user' => $this->user,
            /*'chats' => $this->chats,
            'likedPosts' => $this->likedPosts,
            'viewedPosts' => $this->viewedPosts,
            'repostedPosts' => $this->repostedPosts*/
            'is_followed' => $this->is_followed,
            'notifications' => NotificationResource::collection($this->notifications)->resolve()
        ];

        //eturn parent::toArray($request);
    }
}
