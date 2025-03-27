<?php

namespace JeffersonGoncalves\Filament\OneTimeOperations;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class OneTimeOperationsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-one-time-operations')
            ->hasConfigFile()
            ->hasTranslations();
    }
}
