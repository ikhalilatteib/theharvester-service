<?php

namespace Ikay\TheharvesterService;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Ikay\TheharvesterService\Commands\TheharvesterServiceCommand;

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
            ->hasMigration('create_theharvester-service_table')
            ->hasCommand(TheharvesterServiceCommand::class);
    }
}
