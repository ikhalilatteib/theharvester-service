<?php

namespace Ikay\TheharvesterService\Listeners;

use Ikay\TheharvesterService\Events\TaskTheharvesterCreated;
use Illuminate\Contracts\Queue\ShouldQueue;

class TaskTheharvesterService implements ShouldQueue
{
    public $timeout = 300;

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
    public function handle(TaskTheharvesterCreated $event): void
    {

    }
}
