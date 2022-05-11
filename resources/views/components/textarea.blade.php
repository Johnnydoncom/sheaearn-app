@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full textarea textarea-bordered rounded-none']) !!}>{{ $slot }}</textarea>