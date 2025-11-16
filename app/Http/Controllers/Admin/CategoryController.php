<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $categories = CategoryResource::collection($categories)->resolve();
        return inertia('Admin/Category/Index', compact('categories'));
    }

    public function show(Category $category)
    {
        $category = CategoryResource::make($category)->resolve();
        return inertia('Admin/Category/Show', compact('category'));
    }

    public function create()
    {
        return inertia('Admin/Category/Create');
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $category = Category::query()->create($data);
        $category = CategoryResource::make($category)->resolve();
        return $category;
    }
}
