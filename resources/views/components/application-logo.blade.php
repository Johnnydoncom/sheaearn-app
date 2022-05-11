@props(['type' => 'dark'])
<img src="{{ $type=='dark' ? \Storage::url('logo.png') : \Storage::url('logo-white.png') }}" {{ $attributes->merge(['class' => 'rounded-md']) }}>
