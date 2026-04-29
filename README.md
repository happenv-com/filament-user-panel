# Filament User Panel

This package draws inspiration from [Filament Breezy](https://github.com/jeffgreco13/filament-breezy) but does not include two-factor authentication (2FA) functionality.

Rather than offering multiple plugin options, this package provides a streamlined approach to extending and replacing components.

## Installation

To install the package, execute the following command:

```sh
composer require happenv/filament-user-panel
```

## Register Plugin

To register the plugin, use the following code snippet:

```php
use Happenv\FilamentUserProfile\UserProfilePlugin;

$panel->plugins([
    UserProfilePlugin::make()
]);
```

## Options

### Register User Menu Item

Control whether the plugin should automatically register the user menu item:

```php
UserProfilePlugin::make()
    ->registerUserMenu(false);
```

### Custom Profile Page

Replace the entire `ProfilePage` with your custom component:

```php
UserProfilePlugin::make()
    ->profilePage(MyProfileComponent::class);
```

### Custom Profile Components

Manage the registered components and their order:

```php
use Happenv\FilamentUserProfile\Livewire\PersonalInfo;
use Happenv\FilamentUserProfile\Livewire\UpdatePassword;

UserProfilePlugin::make()
    ->profileComponents([
        'personal_info' => PersonalInfo::class,
        'update_password' => UpdatePassword::class,
    ]);
```

### Replace Profile Component

Replace a specific profile component:

```php
use My\Component\PersonalInfo;

UserProfilePlugin::make()
    ->replaceProfileComponent('personal_info', PersonalInfo::class);
```

### Register New Profile Component

Register a new profile component:

```php
use My\Component\SomeComponent;

UserProfilePlugin::make()
    ->registerProfileComponent('some_component', SomeComponent::class);
```

### Remove Profile Component

Remove a specific profile component:

```php
use My\Component\SomeComponent;

UserProfilePlugin::make()
    ->removeProfileComponent('personal_info');
```

## Laravel Sanctum

Laravel Sanctum is automatically detected, and a component to manage Sanctum tokens is displayed in the profile. Control the available abilities with the following code:

```php
UserProfilePlugin::make()
    ->sanctumAbilities(['read', 'write']);
```

By default, all tokens are registered with all abilities (`[*]`).

## Two-Factor Authentication

This package is compatible with [stephenjude/filament-two-factor-authentication](https://github.com/stephenjude/filament-two-factor-authentication). Simply register the component as shown below:

```php
UserProfilePlugin::make()
    ->registerProfileComponent('2fa', \Stephenjude\FilamentTwoFactorAuthentication\Livewire\TwoFactorAuthentication::class)
```
