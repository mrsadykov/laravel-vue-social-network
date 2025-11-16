<?php

namespace App\Exceptions;

use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

class PostException extends Exception
{
    public function __construct(private Post|null $post, $message = '', $code = 0, Throwable|null $previous)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Report the exception. (для логирования)
     */
    public function report(): void
    {
        Log::channel('post')->info('post already exists, id: {id}', [ 'id' => $this->post->id ]);
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): Response
    {
        return response([
            'message' => $this->message,
            'post' => $this->post->id
        ], $this->code);
    }

    /*public static function ifPostNotExists(Post|null $post)
    {
        if (!$post) {
            throw new PostException(null, 'post not found', 422, null);
        }
    }*/

    public static function ifPostExists(Post|null $post)
    {
        if ($post) {
            throw new PostException($post, 'post is already exists', 422, null);
        }
    }
}
