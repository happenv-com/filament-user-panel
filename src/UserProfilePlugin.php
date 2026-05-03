<?php

namespace Happenv\FilamentUserProfile;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Happenv\FilamentUserProfile\Livewire\BrowserSessions;
use Happenv\FilamentUserProfile\Livewire\Passkeys;
use Happenv\FilamentUserProfile\Livewire\PersonalInfo;
use Happenv\FilamentUserProfile\Livewire\SanctumTokens;
use Happenv\FilamentUserProfile\Livewire\TwoFactorAuth;
use Happenv\FilamentUserProfile\Livewire\UpdatePassword;
use Happenv\FilamentUserProfile\Pages\MyProfilePage;
use Livewire\Livewire;

class UserProfilePlugin implements Plugin
{
    use EvaluatesClosures;

    // NEW
    protected string $profilePage = MyProfilePage::class;

    protected string $slug = 'my-profile';

    protected array $profileComponents = [
        'personal_info' => PersonalInfo::class,
        'update_password' => UpdatePassword::class,
        'browser_sessions' => BrowserSessions::class,
        'sanctum_tokens' => SanctumTokens::class,
        'passkeys' => Passkeys::class,
        'two_factor_auth' => TwoFactorAuth::class,
    ];

    protected bool $hasAvatars = true;

    protected array $sanctumAbilities = [];

    public function getId(): string
    {
        return 'filament-user-profile';
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    public function register(Panel $panel): void
    {

        // ->profile($this->getProfilePage())

        $this->getRegisteredMyProfileComponents()->each(
            fn (string $component, string $key) => Livewire::component($key, $component)
        );
    }

    public function profilePage(string $page): static
    {
        $this->profilePage = $page;

        return $this;
    }

    public function getProfilePage()
    {
        return $this->profilePage;
    }

    public function profileComponents(array $components): static
    {
        $this->profileComponents = $components;

        return $this;
    }

    public function getProfileComponents(): array
    {
        return $this->profileComponents;
    }

    public function replaceProfileComponent(string $key, string $component): static
    {
        $this->profileComponents[$key] = $component;

        return $this;
    }

    public function removeProfileComponent(string $key): static
    {
        unset($this->profileComponents[$key]);

        return $this;
    }

    public function registerProfileComponent(string $key, string $component): static
    {
        $this->profileComponents[$key] = $component;

        return $this;
    }

    public function sanctumAbilities(array $abilities): static
    {
        $this->sanctumAbilities = $abilities;

        return $this;
    }

    public function getSanctumAbilities(): array
    {
        return collect($this->sanctumAbilities)->mapWithKeys(function ($item, $key) {
            $key = is_string($key) ? $key : strtolower($item);

            return [$key => $item];
        })->toArray();
    }

    public function boot(Panel $panel): void
    {
        // $this->userMenuRegistration();

    }

    public function getRegisteredMyProfileComponents()
    {
        $components = collect($this->getProfileComponents())
            ->each(
                fn (string $component, $key) => Livewire::component($key, $component)
            )
            ->filter(
                function (string $component) {
                    if (\method_exists($component, 'canView')) {
                        return $component::canView();
                    }

                    return true;
                }
            )
            ->sortBy(
                function (string $component) {
                    if (\method_exists($component, 'getSort')) {
                        return $component::getSort();
                    }

                    // put at last place
                    return 999;
                }
            );

        return $components;
    }
}
