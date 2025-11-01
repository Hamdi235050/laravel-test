@props([
    'title' => 'Aucun élément trouvé',
    'subtitle' => null,
    'icon' => null,
    'colSpan' => false
])

<div {{ $attributes->merge(['class' => ($colSpan ? 'col-span-full ' : '') . 'empty-state']) }}>
    @if($icon)
        {{ $icon }}
    @else
        <x-icons.building class="mx-auto text-gray-400 mb-4" />
    @endif
    
    <p class="empty-state-title">{{ $title }}</p>
    
    @if($subtitle)
        <p class="empty-state-subtitle">{{ $subtitle }}</p>
    @endif
    
    @if($slot->isNotEmpty())
        <div class="mt-4">
            {{ $slot }}
        </div>
    @endif
</div>
