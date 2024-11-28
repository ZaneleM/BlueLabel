<?php

namespace App\Listeners;

use App\Events\PersonCreated;
use App\Jobs\SendPersonCreatedEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPersonCreatedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PersonCreated $event)
    {
        SendPersonCreatedEmail::dispatch($event->person);
    }
}
