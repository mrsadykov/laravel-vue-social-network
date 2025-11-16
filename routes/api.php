<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ProfileController;
//use App\Http\Controllers\Api\RepostController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Middleware\IsAdminMiddleware;
use App\Http\Middleware\IsModerator;
use App\Models\Video;
use App\Http\Middleware\DbListenMiddleware;

Route::post('auth/login', [ AuthController::class, 'login' ]);

Route::group([ 'middleware' => 'jwt.auth','prefix' => 'auth' ], function () {
    Route::post('logout', [ AuthController::class, 'logout' ]);
    Route::post('refresh', [ AuthController::class, 'refresh' ]);
    Route::post('me', [ AuthController::class, 'me' ]);
});

//Route::get('/posts', [ PostController::class, 'index' ]);
//Route::get('/posts/{post}', [ PostController::class, 'show' ]);
//Route::post('/posts', [ PostController::class, 'store' ]);
//Route::patch('/posts/{post}', [ PostController::class, 'update' ]);
//route::delete('/posts/{post}', [ PostController::class, 'destroy' ]);

Route::group([ 'middleware' =>
        [
            //'jwt.auth',
            //IsAdminMiddleware::class,
            //IsModerator::class
            DbListenMiddleware::class,
        ]
    ], function () {
        Route::apiResource('posts', PostController::class);
        Route::apiResource('users', UserController::class);
        Route::apiResource('messages', MessageController::class);
        Route::apiResource('comments', CommentController::class);
        //Route::apiResource('reposts', RepostController::class);
        Route::apiResource('profiles', ProfileController::class);
        Route::apiResource('tags', TagController::class);
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('chats', ChatController::class);

        // temp
        Route::get('videos', [ VideoController::class, 'index' ])->name('videos.index');
        Route::post('videos', [ VideoController::class, 'store' ])->name('videos.store');
        Route::delete('videos/{video}', [ VideoController::class, 'destroy' ])->name('videos.destroy');
});
