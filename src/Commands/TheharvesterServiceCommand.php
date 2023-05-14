<?php

namespace Ikay\TheharvesterService\Commands;

use Illuminate\Console\Command;

class TheharvesterServiceCommand extends Command
{
    public $signature = 'theharvester-service';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
