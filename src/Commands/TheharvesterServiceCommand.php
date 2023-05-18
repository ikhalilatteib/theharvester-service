<?php

namespace Ikay\TheharvesterService\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class TheharvesterServiceCommand extends Command
{
    public $signature = 'theharvester:install';

    public $description = 'Install Theharvester components and sources';

    public function handle(): int
    {

        // pull secsi/theharvester:latest image

        $client = new Client([
            'base_uri' => config('services.docker.endpoint'),
            'timeout' => config('services.docker.timeout'),
        ]);
        $client->post('/images/create?fromImage=secsi/theharvester:latest');
        $this->info('secsi/theharvester:latest image has been pulled');

        $this->callSilent('vendor:publish', ['--tag' => 'theharvester-service-config', '--force' => true]);
        $this->info('config/theharvester-service.php has been published');
        $this->callSilent('vendor:publish', ['--tag' => 'theharvester-service-migrations', '--force' => true]);
        $this->info('database/migrations/create_theharvester_service_table.php has been published');
        $this->callSilent('vendor:publish', ['--tag' => 'theharvester-service-views', '--force' => true]);
        $this->info('resources/views/vendor/theharvester has been published');

        $file = app_path('Providers/EventServiceProvider.php');
        $contents = file_get_contents($file);

        if (! str_contains($contents, ' \Ikay\TheharvesterService\Events\TaskTheharvesterCreated::class')) {
            $search = 'protected $listen = [';
            $replace = "$search\n        \Ikay\TheharvesterService\Events\TaskTheharvesterCreated::class => [\n            \Ikay\TheharvesterService\Listeners\TaskTheharvesterService::class,\n        ],";
            $contents = str_replace($search, $replace, $contents);
        }
        file_put_contents($file, $contents);

        $this->info('All done');

        return self::SUCCESS;
    }
}
