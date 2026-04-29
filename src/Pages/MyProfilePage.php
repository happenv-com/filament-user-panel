<?php

namespace Happenv\FilamentUserProfile\Pages;

use Filament\Pages\Page;
use Happenv\FilamentUserProfile\UserProfilePlugin;

class MyProfilePage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament-user-profile::filament.pages.my-profile';

    public static function getPlugin(): UserProfilePlugin
    {
        /** @var UserProfilePlugin $plugin */
        $plugin = filament('filament-user-profile');

        return $plugin;
    }

    public function getTitle(): string
    {
        return __('filament-user-profile::default.profile.my_profile');
    }

    public function getHeading(): string
    {
        return __('filament-user-profile::default.profile.my_profile');
    }

    public function getSubheading(): ?string
    {
        return __('filament-user-profile::default.profile.subheading') ?? null;
    }

    public static function getSlug(): string
    {
        return static::getPlugin()->slug();
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-user-profile::default.profile.profile');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function getRegisteredMyProfileComponents()
    {
        return static::getPlugin()->getRegisteredMyProfileComponents();
    }
}
