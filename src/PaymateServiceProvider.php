<?php

namespace Homeful\Paymate;

use Homeful\Paymate\Commands\PaymateCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->hasConfigFile(['paymate'])
            // ->hasViews()
            // ->hasAssets()
            ->hasMigration('create_paymate_table')
            ->hasCommand(PaymateCommand::class);
    }
}
