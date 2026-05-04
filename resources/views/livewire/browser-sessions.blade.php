<x-filament::section :aside="true">
    <x-slot name="heading">
        {{__('happenv-filament-user-profile::default.profile.browser_sessions.heading')}}
    </x-slot>

    <x-slot name="description">
       {{__('happenv-filament-user-profile::default.profile.browser_sessions.subheading')}}
    </x-slot>

    <div class="">

            {{ $this->form }}


        <x-filament-actions::modals />
    </div>
</x-filament::section>
