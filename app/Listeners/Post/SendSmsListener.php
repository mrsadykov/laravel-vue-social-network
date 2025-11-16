<?php

namespace App\Listeners\Post;

use App\Events\Post\StoredPostEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSmsListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(StoredPostEvent $event): void
    {
        //dump($event->post->toArray());
    }
}
