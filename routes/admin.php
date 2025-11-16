<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ModelController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Middleware\IsAdminMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\StatController;

Route::group([ 'prefix' => 'admin', 'middleware' => [ 'auth', IsAdminMiddleware::class ] ], function () {
    Route::get('models', [ ModelController::class, 'index' ])->name('admin.models.index');

    Route::group([ 'prefix' => 'posts' ], function () {
        Route::get('/', [ PostController::class, 'index' ])->name('admin.posts.index');
        Route::get('create', [ PostController::class, 'create' ])->name('admin.posts.create');
        Route::get('{post}', [ PostController::class, 'show' ])->name('admin.posts.show');

        Route::get('{post}/edit', [ PostController::class, 'edit' ])->name('admin.posts.edit');
        Route::patch('{post}', [ PostController::class, 'update' ])->name('admin.posts.update');

        Route::delete('{post}', [ PostController::class, 'destroy' ])->name('admin.posts.destroy');

        // добавить или удалить лайк
        Route::post('/{post}/toggle-like', [ PostController::class, 'toggleLike' ])->name('admin.posts.like.toggle');

        Route::post('/', [ PostController::class, 'store' ])->name('admin.posts.store');
    });

    Route::group([ 'prefix' => 'categories' ], function () {
        Route::get('/', [ CategoryController::class, 'index' ])->name('admin.categories.index');
        Route::get('create', [ CategoryController::class, 'create' ])->name('admin.categories.create');
        Route::get('{category}', [ CategoryController::class, 'show' ])->name('admin.categories.show');
        Route::post('/', [ CategoryController::class, 'store' ])->name('admin.categories.store');
    });

    Route::group([ 'prefix' => 'tags' ], function () {
        Route::get('/', [TagController::class, 'index'])->name('admin.tags.index');
        Route::get('create', [ TagController::class, 'create' ])->name('admin.tags.create');
        Route::get('{tag}', [TagController::class, 'show'])->name('admin.tags.show');
        Route::post('/', [ TagController::class, 'store' ])->name('admin.tags.store');
    });

    Route::get('chats', [ ChatController::class, 'index' ])->name('admin.chats.index');
    Route::get('chats/{chat}', [ ChatController::class, 'show' ])->name('admin.chats.show');

    Route::get('messages', [ MessageController::class, 'index' ])->name('admin.messages.index');
    Route::get('messages/{message}', [ MessageController::class, 'show' ])->name('admin.messages.show');

    Route::get('profiles', [ ProfileController::class, 'index' ])->name('admin.profiles.index');
    Route::get('profiles/{profile}', [ ProfileController::class, 'show' ])->name('admin.profiles.show');

    Route::get('stats', [ StatController::class, 'index' ])->name('admin.stats.index');
});
