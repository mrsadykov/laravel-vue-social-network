<?php

namespace App\Listeners\Log;

use App\Events\Log\AfterStoredLogEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AfterStoredListener
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
    public function handle(AfterStoredLogEvent $event): void
    {
        dump('AfterStoredLogEvent');
    }
}
