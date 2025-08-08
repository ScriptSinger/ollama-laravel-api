<x-filament-panels::page>
    <form wire:submit.prevent="send" class="flex gap-3 items-center">
        <x-filament::input
            wire:model.defer="prompt"
            type="text"
            placeholder="Введите запрос к Mistral..."
            class=""
            autocomplete="off" />

        <x-filament::button type="submit" color="primary" class="px-6 py-3 font-semibold">
            Отправить
        </x-filament::button>
    </form>

    @if ($response)
    <x-filament::card class="mt-6 whitespace-pre-wrap font-mono text-sm select-text break-words">
        {{ $response }}
    </x-filament::card>
    @endif
</x-filament-panels::page>