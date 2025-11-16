<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Category\IndexRequest;
use App\Http\Requests\Api\Category\StoreRequest;
use App\Http\Requests\Api\Category\UpdateRequest;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request)
    {
        $data = $request->validated();
        $categories = Category::filter($data)->get();
        return CategoryCollection::make($categories)->resolve();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $category = CategoryService::create($data);
        return CategoryResource::make($category)->resolve();
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return CategoryResource::make($category)->resolve();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Category $category)
    {
        $data = $request->validated();
        $category = CategoryService::update($category, $data);
        return CategoryResource::make($category)->resolve();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        CategoryService::delete($category);
        return response()->json([
            'message' => 'Category deleted'
        ], Response::HTTP_OK);
    }
}
