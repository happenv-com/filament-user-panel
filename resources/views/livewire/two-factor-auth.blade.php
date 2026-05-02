<x-filament::section :aside="true">
    <x-slot name="heading">
        {{ __('filament-passkeys::passkeys.passkeys') }}
    </x-slot>

    <x-slot name="description">
        {{ __('filament-passkeys::passkeys.description') }}
    </x-slot>


    <form wire:submit.prevent="save" class="space-y-6">
    {{ $this->form }}
    </form>

     <x-filament-actions::modals />

</x-filament::section>
