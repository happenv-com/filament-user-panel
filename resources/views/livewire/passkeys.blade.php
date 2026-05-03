<x-filament::section :aside="true">
    <x-slot name="heading">
        {{ __('happenv-filament-user-profile::default.profile.passkeys.title') }}
    </x-slot>

    <x-slot name="description">
        {{ __('happenv-filament-user-profile::default.profile.passkeys.description') }}
    </x-slot>

    <div>
    <div>
        <form id="passkeyForm" wire:submit="validatePasskeyProperties" class="flex items-start space-x-2">
            <div class="w-full fi-fo-field">
                <x-filament::input.wrapper prefix="{{ __('happenv-filament-user-profile::default.profile.passkeys.name') }}" :valid="! $errors->has('name')">
                    <x-filament::input
                        type="text"
                        wire:model="name"
                    />
                </x-filament::input.wrapper>

                @error('name')
                    <p class="fi-fo-field-wrp-error-message">{{ $message }}</p>
                @enderror
            </div>

            <x-filament::button type="submit">
                {{ __('happenv-filament-user-profile::default.profile.passkeys.create') }}
            </x-filament::button>
        </form>
    </div>

    @if($passkeys->isNotEmpty())
        <div class="mt-6">
            <span class="font-bold text-sm">{{ __('happenv-filament-user-profile::default.profile.passkeys.title') }}</span>
            <ul class="space-y-4">
                @foreach($passkeys as $passkey)
                    <x-filament::fieldset class="mt-2">
                        <div class="flex items-center">
                            <div class="mr-2 flex flex-col">
                                <span>{{ $passkey->name }}</span>
                                <span class="text-xs fi-sc-text">{{ __('happenv-filament-user-profile::default.profile.passkeys.last_used') }}: {{ $passkey->last_used_at?->diffForHumans() ?? __('happenv-filament-user-profile::default.profile.passkeys.not_used_yet') }}</span>
                            </div>

                            <div class="ml-auto">
                                {{ ($this->deleteAction)(['passkey' => $passkey->id]) }}
                            </div>
                        </div>
                    </x-filament::fieldset>
                @endforeach
            </ul>
        </div>
    @endif

    <x-filament-actions::modals />
</div>
</x-filament::section>
@include('passkeys::livewire.partials.createScript')
