<?php

namespace Homeful\Paymate;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Homeful\Paymate\Commands\PaymateCommand;

class PaymateServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('paymate')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_paymate_table')
            ->hasCommand(PaymateCommand::class);
    }
}
