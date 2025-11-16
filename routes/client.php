<?php

use App\Http\Controllers\Client\ChatController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\DashboardController;
use App\Http\Controllers\Client\NotificationController;
use App\Http\Controllers\Client\PostController;
use App\Http\Controllers\Client\ProfileController;
use Illuminate\Support\Facades\Cache;

Route::group([ 'middleware' => [ 'auth' ] ], function() {
    Route::get('dashboard', [ DashboardController::class, 'index' ])->name('dashboard');

    Route::group([ 'prefix' => 'posts/{post}' ], function() {
        Route::get('', [ PostController::class, 'show' ])->name('client.posts.show');
        Route::delete('', [ PostController::class, 'destroy' ])->name('client.posts.destroy');

        Route::group([ 'prefix' => 'comments'], function() {
            Route::post('', [ PostController::class, 'storeComment' ])->name('client.posts.comments.store');
            Route::get('', [ PostController::class, 'indexComment' ])->name('client.posts.comments.index');

            Route::group([ 'prefix' => '{comment}' ], function() {
                Route::post('toggle-like', [ PostController::class, 'toggleCommentLike' ])->name('client.posts.comments.like.toggle');
                Route::delete('', [ PostController::class, 'destroyComment' ])->name('client.posts.comments.destroy');
            });
        });
    });

    Route::group([ 'prefix' => 'profiles' ], function() {
        Route::get('self', [ ProfileController::class, 'self' ])->name('client.profiles.self');
        Route::get('notifications', [ ProfileController::class, 'indexNotification' ])->name('client.profiles.notifications.index');

        Route::group([ 'prefix' => '{profile}' ], function() {
            Route::post('following-toggle', [ ProfileController::class, 'toggleFollowing' ])->name('client.profiles.followings.toggle');
            Route::get('', [ ProfileController::class, 'show' ])->name('client.profiles.show');
        });

        Route::post('posts/{post}/repost', [ ProfileController::class, 'repost' ])->name('client.profiles.posts.repost');
        Route::get('', [ ProfileController::class, 'index' ])->name('client.profiles.index');
    });

    Route::group([ 'prefix' => 'chats' ], function() {
        Route::group([ 'prefix' => '{chat}' ], function() {
            Route::get('', [ ChatController::class, 'show' ])->name('client.chats.show');
            Route::post('messages', [ ChatController::class, 'storeMessage'])->name('client.chats.messages.store');
            Route::get('messages', [ ChatController::class, 'getMessages' ])->name('client.chats.messages.get');
        });

        Route::post('', [ ChatController::class, 'store' ])->name('client.chats.store');
        Route::get('', [ ChatController::class, 'index' ])->name('client.chats.index');
    });


    Route::group([ 'prefix' => 'notifications' ], function() {
        Route::get('', [ NotificationController::class, 'index' ])->name('client.notifications.index');
        Route::patch('', [ NotificationController::class, 'updateMarkAllAsRead' ])->name('client.notifications.update.markAllAsRead');
    });
});

Route::get('/cache-flush', function() {
    Cache::flush();
});

Route::get('/test', function() {
    Cache::put('name', 'Laravel with Redis', 600);
    return 'Success';
});

Route::get('/redis', function() {
    //return Cache::get('name', 'default');
    $data = [
        "page" => "2",
        "per_page" => 2,
        "post_id" => 21
    ];
    //dd($data);

    $key = md5(json_encode($data));

    return Cache::get($key);
});
