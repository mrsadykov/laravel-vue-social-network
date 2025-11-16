<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\Image\ImageCollection;
use App\Http\Resources\Image\ImageResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // ресурсы - это фильтр атрибутов (ничего остального не должен делать)
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            //'img_path' => $this->img_path,
            //'img_url' => $this->img_url,
            //'images' => ImageCollection::make($this->images)->resolve(),
            'images' => ImageResource::collection($this->images)->resolve(),
            'video' => $this->video,
            'published_at' => Carbon::parse($this->published_at)->format('Y-m-d'),
            //'published_at' => $this->published_at,
            'is_active' => $this->is_active,
            'category_id' => $this->category_id,
            'profile_id' => $this->profile_id,
            'parent_id' => $this->parent_id,
            'is_liked' => $this->is_liked,
            'signature' => $this->signature,
            'liked_by_profiles_count' => $this->liked_by_profiles_count,

            //'likedByProfilesRelation' => $this->likedByProfiles(),
            //'likedByProfilesCollection' => $this->likedByProfiles,

            // additional
            //'category' => $this?->category?->title,
            'profile_login' => $this?->profile?->login,
            'tags' => $this?->tags?->pluck('id')->toArray(),
            //'likes' => $this?->likedByProfiles?->count(),
            'views' => $this->viewed_by_profiles_count, //$this?->viewedByProfiles?->count(),
        ];
    }
}
