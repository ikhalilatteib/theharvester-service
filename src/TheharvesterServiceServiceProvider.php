<?php

namespace Ikay\TheharvesterService;

use Ikay\TheharvesterService\Commands\TheharvesterServiceCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TheharvesterServiceServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('theharvester-service')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_theharvester_service_table')
            ->hasCommand(TheharvesterServiceCommand::class)
            ->hasRoute('routes');
    }
}
