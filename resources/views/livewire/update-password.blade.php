

<x-filament::section :aside="true">
    <x-slot name="heading">
        {{__('happenv-filament-user-profile::default.profile.password.heading')}}
    </x-slot>

    <x-slot name="description">
        {{__('happenv-filament-user-profile::default.profile.password.subheading')}}
    </x-slot>

    <div class="">
        <form wire:submit.prevent="submit" class="space-y-6">

            {{ $this->form }}

            <div class="text-right">
                <x-filament::button type="submit" form="submit" class="align-right">
                    {{ __('happenv-filament-user-profile::default.profile.password.submit.label') }}
                </x-filament::button>
            </div>
        </form>
    </div>
</x-filament::section>
