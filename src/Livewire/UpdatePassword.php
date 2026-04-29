<?php

namespace Happenv\FilamentUserProfile\Livewire;

use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UpdatePassword extends MyProfileComponent
{
    protected string $view = 'filament-user-profile::livewire.update-password';

    public ?array $data = [];

    public $user;

    public static $sort = 20;

    public function mount()
    {
        $this->user = Filament::getCurrentPanel()->auth()->user();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('current_password')
                    ->label(__('filament-user-profile::default.password_confirm.current_password'))
                    ->required()
                    ->password()
                    ->rule('current_password'),
                Forms\Components\TextInput::make('new_password')
                    ->label(__('filament-user-profile::default.fields.new_password'))
                    ->password()
                    ->rules([Password::defaults()])
                    ->required(),
                Forms\Components\TextInput::make('new_password_confirmation')
                    ->label(__('filament-user-profile::default.fields.new_password_confirmation'))
                    ->password()
                    ->same('new_password')
                    ->required(),
            ])
            ->statePath('data');
    }

    public function submit()
    {
        $data = collect($this->getForm('form')->getState())->only('new_password')->all();
        $this->user->update([
            'password' => Hash::make($data['new_password']),
        ]);
        session()->forget('password_hash_'.Filament::getCurrentPanel()->getAuthGuard());
        Filament::auth()->login($this->user);
        $this->reset(['data']);
        Notification::make()
            ->success()
            ->title(__('filament-user-profile::default.profile.password.notify'))
            ->send();
    }
}
