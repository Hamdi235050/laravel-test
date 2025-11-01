@props(['property', 'showBookings' => false])

<div class="card card-hover">
    <div class="card-image">
        @if(isset($property->image) && $property->image)
            <img src="{{ $property->image }}" alt="{{ $property->name }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
        @else
            <div class="flex items-center justify-center h-full text-gray-400">
                <x-icons.home size="w-16 h-16" />
            </div>
        @endif
        
        <div class="card-image-overlay"></div>
        
        <div class="absolute top-4 right-4">
            <span class="card-badge-success">
                Disponible
            </span>
        </div>
    </div>

    <div class="card-body">
        <h3 class="card-title">{{ $property->name }}</h3>
        <p class="card-description">{{ $property->description }}</p>
        
        <div class="card-divider"></div>
        
        <div class="price-container">
            <div class="price-label">
                <div class="price-icon-wrapper">
                    <x-icons.clock class="text-primary" />
                </div>
                <span class="text-sm font-semibold">Par nuit</span>
            </div>
            <span class="price-value">{{ number_format($property->price_per_night ?? $property->price ?? 0, 2) }} €</span>
        </div>

        @if($showBookings && isset($property->bookings_count))
            <div class="stats-container">
                <div class="stats-content">
                    <div class="stats-icon-wrapper">
                        <x-icons.users size="w-5 h-5" class="text-secondary" />
                    </div>
                    <span class="font-semibold text-sm">{{ $property->bookings_count }} réservation(s)</span>
                </div>
            </div>
        @endif

        {{ $slot }}
    </div>
</div>