@props(['title' => ''])

{{--<input {!! $attributes->merge(['class' => 'checkbox']) !!} {{ $disabled ? 'disabled' : '' }} {{ $checked ? 'checked' : '' }} type="checkbox">--}}


<div class="flex justify-center">
    <div {!! $attributes->merge(['class' => 'block p-6 rounded-lg shadow-lg bg-white w-full']) !!}>
        @isset($title)
        {{ $title }}
        @endisset

        {{ $slot }}

        @isset($button)
            {{ $button }}
        @endisset
    </div>
</div>
