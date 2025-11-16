<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\Profile\ProfileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'content' => $this->content,
            'profile' => ProfileResource::make($this->profile)->resolve(),
            'formatted_date' => $this->formatted_date,
            'published_at' => $this->published_at,
            'liked_by_profiles_count' => $this->liked_by_profiles_count,
            'is_liked' => $this->is_liked,
            'parent_comment_id' => $this->parent,
            'answers' => CommentResource::collection($this->answers)->resolve(),
            'addAnswer' => false
        ];
    }
}
