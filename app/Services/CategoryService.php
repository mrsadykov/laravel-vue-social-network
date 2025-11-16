<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public static function create($data)
    {
        return Category::query()->create($data);
    }

    public static function update(Category $category, array $data)
    {
        $category->update($data);
        return $category;
    }

    public static function delete(Category $category)
    {
        $category->delete();
        return $category;
    }
}
