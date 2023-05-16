<?php

namespace Ikay\TheharvesterService\Commands;

use Illuminate\Console\Command;

class TheharvesterServiceCommand extends Command
{
    public $signature = 'theharvester:install';

    public $description = 'Install Theharvester components and sources';

    public function handle(): int
    {
        $this->callSilent('vendor:publish', ['--tag' => 'theharvester-service-config', '--force' => true]);
        $this->callSilent('vendor:publish', ['--tag' => 'theharvester-service-migrations', '--force' => true]);
        $this->callSilent('vendor:publish', ['--tag' => 'theharvester-service-views', '--force' => true]);

        $file = app_path('Providers/EventServiceProvider.php');
        $contents = file_get_contents($file);

    
        if (! str_contains($contents, ' \Ikay\TheharvesterService\Events\TaskTheharvesterCreated::class')) {
            $search = 'protected $listen = [';
            $replace = "$search\n        \Ikay\TheharvesterService\Events\TaskTheharvesterCreated::class => [\n            \Ikay\TheharvesterService\Listeners\TaskTheharvesterService::class,\n        ],";
            $contents = str_replace($search, $replace, $contents);
        }
        file_put_contents($file, $contents);

        $this->comment('All done');

        return self::SUCCESS;
    }
}
