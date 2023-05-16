<?php

namespace Ikay\TheharvesterService\Listeners;

use Ikay\TheharvesterService\Events\TaskTheharvesterCreated;
use Ikay\TheharvesterService\TheharvesterService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

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
        Log::info('it work');
        (new TheharvesterService($event->theharvester))->createTheharvesterContainer();
    }
}
