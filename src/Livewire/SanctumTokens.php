<?php

namespace Happenv\FilamentUserProfile\Livewire;

use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Tables;
use Happenv\FilamentUserProfile\UserProfilePlugin;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class SanctumTokens extends MyProfileComponent implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected string $view = 'filament-user-profile::livewire.sanctum-tokens';

    protected string $modalWidth = 'md';

    protected int $abilityColumns = 2;

    public $user;

    public ?string $plainTextToken;

    public static $sort = 40;

    public function mount()
    {
        $this->user = Filament::getCurrentPanel()->auth()->user();
    }

    protected function getTableQuery(): Builder
    {
        $auth = Filament::getCurrentPanel()->auth();

        /** @var PersonalAccessToken $sanctumModel */
        $sanctumModel = Sanctum::$personalAccessTokenModel;

        /** @var Model $user */
        $user = $auth->user();

        return app($sanctumModel)->where([
            ['tokenable_id', '=', $auth->id()],
            ['tokenable_type', '=', $user->getMorphClass()],
        ]);
    }

    public static function canView(): bool
    {
        return class_exists('Laravel\Sanctum\Sanctum');
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable()
                ->label(__('filament-user-profile::default.fields.token_name')),
            Tables\Columns\TextColumn::make('created_at')
                ->date()
                ->label(__('filament-user-profile::default.fields.created'))
                ->sortable(),
            Tables\Columns\TextColumn::make('expires_at')
                ->color(fn ($record) => now()->gt($record->expires_at) ? 'danger' : null)
                ->date()
                ->label(__('filament-user-profile::default.fields.expires'))
                ->placeholder(__('filament-user-profile::default.fields.never_expires'))
                ->sortable(),
            Tables\Columns\TextColumn::make('abilities')
                ->badge()
                ->label(__('filament-user-profile::default.fields.abilities'))
                ->getStateUsing(fn ($record) => count($record->abilities)),
        ];
    }

    protected function getSanctumFormSchema(bool $edit = false): array
    {
        $plugin = UserProfilePlugin::get();

        $abilities = $plugin->getSanctumAbilities();

        return [
            Forms\Components\TextInput::make('token_name')
                ->label(__('filament-user-profile::default.fields.token_name'))
                ->required()
                ->hidden($edit),
            Forms\Components\CheckboxList::make('abilities')
                ->label(__('filament-user-profile::default.fields.abilities'))
                ->options($abilities)
                ->columns($this->abilityColumns)
                ->hidden(count($abilities) === 0)
                ->required(),
            Forms\Components\DatePicker::make('expires_at')
                ->label(__('filament-user-profile::default.fields.token_expiry'))
                ->disabled(fn (Get $get) => $get('never_expires') === true)
                ->required(fn (Get $get) => $get('never_expires') === false),

            Forms\Components\Toggle::make('never_expires')
                ->label(__('filament-user-profile::default.fields.never_expires'))
                ->dehydrated()
                ->default(false)
                ->live(),

        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            Tables\Actions\Action::make('createToken')
                ->label(__('filament-user-profile::default.profile.sanctum.create.submit.label'))
                ->modalWidth($this->modalWidth)
                ->form($this->getSanctumFormSchema())
                ->action(function ($data) {
                    $this->plainTextToken = $this->user->createToken($data['token_name'], isset($data['abilities']) ? array_values($data['abilities']) : ['*'], isset($data['expires_at']) ? Carbon::createFromFormat('Y-m-d', $data['expires_at']) : null)->plainTextToken;
                    Notification::make()
                        ->success()
                        ->title(__('filament-user-profile::default.profile.sanctum.create.notify'))
                        ->send();
                }),
        ];
    }

    // protected function getTableBulkActions(): array
    // {
    //     return [
    //         Tables\Actions\DeleteBulkAction::make()
    //     ];
    // }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\EditAction::make('edit')
                ->label(__('filament-user-profile::default.profile.sanctum.update.submit.label'))
                ->iconButton()
                ->modalWidth($this->modalWidth)
                ->form($this->getSanctumFormSchema(edit: true)),
            Tables\Actions\DeleteAction::make()
                ->iconButton(),
        ];
    }
}
