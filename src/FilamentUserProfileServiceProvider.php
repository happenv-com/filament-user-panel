<?php

namespace Happenv\FilamentUserProfile;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentUserProfileServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('happenv-filament-user-profile')
            ->hasViews()
            ->hasTranslations();
    }
}
