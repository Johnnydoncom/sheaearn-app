
<div x-cloak
    x-data="{ value: @entangle($attributes->wire('model')) }"
    x-init="
        new TomSelect(
            $refs.selectize,
        {
            maxItems: '{{ json_encode($maxitems ?? null) }}',
            create: '{{ isset($create) ? true : false }}',
            createOnBlur: '{{ isset($create) ? true : false }}',
            plugins: ['remove_button'],
            onChange: function(values) {
                value = values
            },
            onInitialize: function(values) {
                if (values != null) {
                    value = values
                }
            },
        })
"
    wire:ignore
>
    <div wire:ignore>
        <select
            class="w-full"
            x-ref="selectize"
            {{ $attributes->whereDoesntStartWith('wire:model') }}
        >
        {{ $slot }}
        </select>
    </div>
</div>

@push('styles')
    <link
        href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css"
        rel="stylesheet"
    />
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js" referrerpolicy="origin"></script>
@endpush
