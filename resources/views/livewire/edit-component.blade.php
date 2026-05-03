<x-filament::section :aside="true">
    <x-slot name="heading">
        {{__('happenv-filament-user-profile::default.profile.personal_info.heading')}}
    </x-slot>

    <x-slot name="description">
        {{__('happenv-filament-user-profile::default.profile.personal_info.subheading')}}
    </x-slot>

    <div class="">
        <form wire:submit.prevent="submit" class="space-y-6">

            {{ $this->form }}

            <div class="text-right">
                <x-filament::button type="submit" form="submit" class="align-right">
                    {{ __('happenv-filament-user-profile::default.profile.personal_info.submit.label') }}
                </x-filament::button>
            </div>
        </form>
    </div>
</x-filament::section>
