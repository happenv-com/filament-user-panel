<?php

namespace Happenv\FilamentUserProfile\Livewire;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Happenv\FilamentUserProfile\UserProfilePlugin;
use Livewire\Component;

abstract class MyProfileComponent extends Component implements HasActions, HasForms
{
    use InteractsWithActions, InteractsWithForms;

    protected string $view = 'happenv-filament-user-profile::livewire.edit-component';

    public static $sort = 0;

    public function getName()
    {
        return str(static::class)->afterLast('\\')->snake();
    }

    public static function getPlugin(): UserProfilePlugin
    {
        /** @var UserProfilePlugin $plugin */
        $plugin = filament('happenv-filament-user-profile');

        return $plugin;
    }

    public function render()
    {
        return view($this->view);
    }

    public static function canView(): bool
    {
        return true;
    }

    public static function getSort(): int
    {
        return static::$sort;
    }

    public static function setSort(int $sort): void
    {
        static::$sort = $sort;
    }
}
