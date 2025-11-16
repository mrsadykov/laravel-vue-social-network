<?php

namespace App\Http\Resources\Message;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Resources\Profile\ProfileResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'published_at' => $this->published_at,
            'content' => $this->content,
            'profile' => ProfileResource::make($this->profile)->resolve(),
            'formatted_date' => $this->formatted_date,
            'chat_id' => $this->chat_id,
            'is_owner' => $this->is_owner,
            //'auth_profile_id' => auth()->user()->profile->id,
            //'profile_id' => $this->profile_id
        ];
    }
}
