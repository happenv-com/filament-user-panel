<x-filament::section :aside="true">
    <x-slot name="heading">
        {{__('filament-user-profile::default.profile.browser_sessions.heading')}}
    </x-slot>

    <x-slot name="description">
       {{__('filament-user-profile::default.profile.browser_sessions.subheading')}}
    </x-slot>

    <div class="">
        <x-filament-panels::form>
            {{ $this->form }}
        </x-filament-panels::form>

        <x-filament-actions::modals />
    </div>
</x-filament::section>
