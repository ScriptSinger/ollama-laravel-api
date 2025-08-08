<x-filament-widgets::widget>
    <x-filament::section>
        <form wire:submit.prevent="send" class="flex gap-2">
            <x-filament::input
                wire:model.defer="prompt"
                placeholder="Введите запрос к Mistral..."
                class="flex-grow" />

            <x-filament::button type="submit" color="primary">
                Отправить
            </x-filament::button>
        </form>

        @if ($response)
        <x-filament::card class="mt-4 whitespace-pre-wrap font-mono text-sm">
            {{ $response }}
        </x-filament::card>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>