<?php

namespace Happenv\FilamentUserProfile;

use Filament\Contracts\Plugin;
use Filament\Facades\Filament;
use Filament\Navigation\MenuItem;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Happenv\FilamentUserProfile\Livewire\BrowserSessions;
use Happenv\FilamentUserProfile\Livewire\PersonalInfo;
use Happenv\FilamentUserProfile\Livewire\SanctumTokens;
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
    ];

    protected bool $registerUserMenu = true;

    protected bool $hasAvatars = false;

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
        $panel
            ->pages([$this->getProfilePage()]);

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
        $this->userMenuRegistration();

        $this->getRegisteredMyProfileComponents()->each(
            fn (string $component, string $key) => Livewire::component($key, $component)
        );
    }

    public function registerUserMenu(bool $condition = true)
    {
        $this->registerUserMenu = $condition;

        return $this;
    }

    private function userMenuRegistration()
    {
        if ($this->registerUserMenu) {
            Filament::serving(function () {
                if (Filament::getCurrentPanel()->hasTenancy()) {
                    // @phpstan-ignore-next-line
                    $tenantId = request()->route()->parameter('tenant');
                    if ($tenantId && $tenant = app(Filament::getCurrentPanel()->getTenantModel())::where(Filament::getCurrentPanel()->getTenantSlugAttribute() ?? 'id', $tenantId)->first()) {
                        Filament::getCurrentPanel()->userMenuItems([
                            'account' => MenuItem::make()->url($this->getProfilePage()::getUrl(panel: Filament::getCurrentPanel()->getId(), tenant: $tenant))->label(__('filament-user-profile::default.user_menu_label')),
                        ]);
                    }
                } else {
                    Filament::getCurrentPanel()->userMenuItems([
                        'account' => MenuItem::make()->url($this->getProfilePage()::getUrl())->label(__('filament-user-profile::default.user_menu_label')),
                    ]);
                }
            });
        }
    }

    public function slug(): string
    {
        return $this->slug;
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
