<?php

namespace App\Services;

use App\Http\Resources\Post\PostResource;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Lcobucci\JWT\Exception;

class PostService
{
    public static function store(array $data): Post
    {
        // Не делать проверок.
        // Без реквеста.
        // Можно вызывать другой сервис.

        DB::beginTransaction();

        try {

            /*if (isset($data['images']) && !empty($data['images'])) {
            $images = $data['images'];
            unset($data['images']);
        }*/

            if (isset($data['post']['imagesPath']) && !empty($data['post']['imagesPath'])) {
                $imagesPath = $data['post']['imagesPath'];
            }
            unset($data['post']['imagesPath']);

            $post = Post::query()->create($data['post']);

            /*if (isset($images) && !empty($images)) {
                foreach ($images as $image) {
                    $path = Storage::disk('public')->put('images', $image);
                    $post->images()->create([
                        'path' => $path
                    ]);
                }

                //$post->refresh();
            }*/

            if (isset($imagesPath) && !empty($imagesPath)) {
                foreach ($imagesPath as $imagePath) {
                    $post->images()->create([
                        'path' => $imagePath
                    ]);
                }
            }

            /*if (!empty($imagesPath)) {
                $post->images()->createMany(
                    array_map(fn ($path) => ['path' => $path], $imagesPath)
                );
            }*/

            $tags = TagService::storeBatch($data['tags']);

            // через массив
            // $post->tags()->attach(array_column($tags, 'id'));

            // через коллекцию
            $post->tags()->attach($tags->pluck('id'));

            DB::commit();
            return $post;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public static function update(Post $post, array $data): Post
    {
        DB::beginTransaction();

        try {

            // добавление картинок
            if (isset($data['post']['imagesPath']) && !empty($data['post']['imagesPath'])) {
                $imagesPath = $data['post']['imagesPath'];
            }
            unset($data['post']['imagesPath']);

            // запись для дальнейшего удаления
            if (isset($data['deletedImagesIds']) && !empty($data['deletedImagesIds'])) {
                $deletedImagesIds = $data['deletedImagesIds'];
            }
            unset($data['deletedImagesIds']);

            $post->update($data['post']);

            // добавление картинок
            if (isset($imagesPath) && !empty($imagesPath)) {
                foreach ($imagesPath as $imagePath) {
                    $post->images()->create([
                        'path' => $imagePath
                    ]);
                }
            }

            if (isset($deletedImagesIds) && !empty($deletedImagesIds)) {
                // Получаем изображения, принадлежащие посту
                $imagesToDelete = $post->images()->whereIn('id', $deletedImagesIds)->get();

                // Удаляем файлы изображений из хранилища
                foreach ($imagesToDelete as $image) {
                    Storage::disk('public')->delete($image->path); // Удаление файла
                    // Или для public disk: Storage::disk('public')->delete($image->path);
                }

                // Удаляем записи из базы данных
                $post->images()->whereIn('id', $deletedImagesIds)->delete();
            }

            // обновление тегов
            $tags = TagService::updateBatch($data['tags']);
            $post->tags()->sync($tags->pluck('id'));

            DB::commit();
            return $post;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public static function delete(Post $post): void
    {
        DB::beginTransaction();

        try {
            $postImagesPaths = $post->images()->pluck('path')->toArray();
            $post->images()->delete();
            Storage::disk('public')->delete($postImagesPaths);
            $post->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
