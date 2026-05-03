<x-filament::section :aside="true">
    <x-slot name="heading">
        {{ __('happenv-filament-user-profile::default.profile.two_factor.title') }}
    </x-slot>

    <x-slot name="description">
        {{ __('happenv-filament-user-profile::default.profile.two_factor.description') }}
    </x-slot>


    <form wire:submit.prevent="save" class="space-y-6">
    {{ $this->form }}
    </form>

     <x-filament-actions::modals />

</x-filament::section>
