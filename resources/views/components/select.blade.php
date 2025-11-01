@props(['options' => []])

<select {{ $attributes->merge(['class' => 'form-input']) }}>
    {{ $slot }}
</select>
