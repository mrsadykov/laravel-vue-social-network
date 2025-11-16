<?php

namespace App\Services;

use App\Models\Tag;
use Illuminate\Support\Collection;

class TagService
{
    /**
     * Получение тегов, либо создание при их отсутствии (через массив)
     *
     * @param $data
     * @return array
     */
    /*public static function storeBatch($data): array
    {
        $tags = [];

        foreach ($data as $tagTitle) {
            $tags[] = Tag::query()->firstOrCreate([
                'title' => trim($tagTitle),
            ]);
        }

        return $tags;
    }*/

    /**
     * Получение тегов, либо создание при их отсутствии (через коллекцию)
     *
     * @param $data
     * @return Collection
     */
    public static function storeBatch($data): Collection
    {
        $tags = collect([]);

        foreach ($data as $tagTitle) {
            $tags->push(Tag::query()->firstOrCreate([
                'title' => trim($tagTitle),
            ]));
        }

        return $tags;
    }

    /**
     * Обновление тегов
     *
     * @param $data
     * @return Collection
     */
    public static function updateBatch($data): Collection
    {
        $data = array_map('trim', $data);

        $tags = collect([]);
        foreach ($data as $tagTitle) {
            $tags->push(Tag::query()->firstOrCreate([
                'title' => $tagTitle,
            ]));
        }

        return $tags;
    }

    /**
     * Получение выбранных тегов
     *
     * @param $data
     * @return string
     */
    public static function getSelectedTags($data): string
    {
        $selectedTags = [];
        $selectedTagsStr = '';

        if (!empty($data)) {
            foreach ($data as $tag) {
                $selectedTags[] = Tag::query()->find($tag)->title;
            }

            if (!empty($selectedTags)) {
                $selectedTagsStr = implode(', ', $selectedTags);
            }
        }

        return $selectedTagsStr;
    }

    public static function create($data)
    {
        return Tag::query()->create($data);
    }

    public static function update(Tag $tag, array $data)
    {
        $tag->update($data);
        return $tag;
    }

    public static function delete(Tag $tag)
    {
        $tag->delete();
        return $tag;
    }
}
