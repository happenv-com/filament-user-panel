<x-filament::page>
    <div class="flex flex-col divide-y space-y-6 divide-gray-900/10 dark:divide-white/10">
        @foreach ($this->getRegisteredMyProfileComponents() as $component)
            @unless(is_null($component))
            <div class="pb-6">
                @livewire($component)
            </div>
            @endunless
        @endforeach
    </div>
</x-filament::page>
