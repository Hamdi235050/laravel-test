@props(['type' => 'button', 'variant' => 'primary'])

@php
    if ($variant === 'primary') {
        $classes = 'btn-primary';
    } elseif ($variant === 'secondary') {
        $classes = 'btn-secondary';
    } elseif ($variant === 'danger') {
        $classes = 'btn-danger';
    } elseif ($variant === 'outline') {
        $classes = 'btn-outline';
    } else {
        $classes = 'btn';
    }
@endphp

<button 
    type="{{ $type }}"
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}
</button>