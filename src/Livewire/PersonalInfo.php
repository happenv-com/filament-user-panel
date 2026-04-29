<?php

namespace Happenv\FilamentUserProfile\Livewire;

use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends MyProfileComponent
{
    protected string $view = 'filament-user-profile::livewire.personal-info';

    public ?array $data = [];

    public $user;

    public $userClass;

    public static $sort = 10;

    public array $only = ['name', 'email'];

    public function mount(): void
    {
        $this->user = Filament::getCurrentPanel()->auth()->user();

        $this->userClass = get_class($this->user);

        /** @var Model $userModel */
        $userModel = $this->user;
        //
        $this->getForm('form')->fill($userModel->only($this->only));
    }

    protected function getProfileFormSchema(): array
    {
        $groupFields = Forms\Components\Group::make([
            $this->getNameComponent(),
            $this->getEmailComponent(),
        ])->columnSpan(2);

        return [
            $groupFields,
        ];
    }

    protected function getNameComponent(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('name')
            ->required()
            ->label(__('filament-user-profile::default.fields.name'));
    }

    protected function getEmailComponent(): Forms\Components\TextInput
    {
        /** @var Model $userModel */
        $userModel = $this->user;

        return Forms\Components\TextInput::make('email')
            ->required()
            ->email()
            ->unique($this->userClass, ignorable: $userModel)
            ->label(__('filament-user-profile::default.fields.email'));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getProfileFormSchema())
            ->statePath('data');
    }

    public function submit(): void
    {
        /** @var Model $userModel */
        $userModel = $this->user;

        $data = collect($this->getForm('form')->getState())->only($this->only)->all();

        $userModel->update($data);

        $this->sendNotification();
    }

    protected function sendNotification(): void
    {
        Notification::make()
            ->success()
            ->title(__('filament-user-profile::default.profile.personal_info.notify'))
            ->send();
    }
}
