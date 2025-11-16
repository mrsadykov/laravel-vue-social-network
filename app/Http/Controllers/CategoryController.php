<?php

namespace App\Http\Controllers;

use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(Category::all())->resolve();
    }

    public function show(Category $category)
    {
        return CategoryResource::make($category)->resolve();
    }

    public function store()
    {
        $data = [
            'title' => 'animals',
        ];

        $category = Category::query()->create($data);
        return CategoryResource::make($category)->resolve();
    }

    public function update(Category $category)
    {
        $data = [
            'title' => 'animals ' . md5(now())
        ];

        $category->update($data);
        return CategoryResource::make($category)->resolve();
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response([
            'message' => 'Category deleted'
        ]);
    }
}
