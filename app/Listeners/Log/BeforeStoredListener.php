<?php

namespace App\Listeners\Log;

use App\Events\Log\BeforeStoredLogEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BeforeStoredListener
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
    public function handle(BeforeStoredLogEvent $event): void
    {
        dump('BeforeStoredLogEvent');
    }
}
