<?php

namespace Ikay\TheharvesterService\Events;

use Ikay\TheharvesterService\Models\Theharvester;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskTheharvesterCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Theharvester $theharvester)
    {
    }
}
