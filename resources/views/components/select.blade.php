@props(['disabled' => false])

<select {!! $attributes->merge(['class' => 'select select-bordered rounded-none']) !!} {{ $disabled ? 'disabled' : '' }}>
    {{ $slot }}
</select>
