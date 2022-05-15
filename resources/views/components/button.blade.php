<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn rounded-none']) }}>
    {{ $slot }}
</button>
