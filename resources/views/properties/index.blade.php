<x-layout active="properties" title="Propriétés Disponibles - Gestion de Réservations">
        <div class="page-header">
            <h1 class="page-title">Nos Propriétés Disponibles</h1>
            <p class="page-subtitle">Découvrez notre sélection de propriétés à louer</p>
        </div>

        @if($properties->isEmpty())
            <x-empty-state 
                title="Aucune propriété disponible pour le moment" 
                subtitle="Revenez plus tard ou contactez-nous pour plus d'informations" />
        @else
            <!-- Grille de propriétés -->
            <div class="grid-properties">
                @foreach($properties as $property)
                    <x-carte-properiete :property="$property" :showBookings="true">
                        <div class="flex gap-3">
                            <a href="/bookings" class="flex-1">
                                <x-button variant="primary" class="w-full">
                                    Réserver
                                </x-button>
                            </a>
                            <a href="{{ route('property.details', $property->id) }}">
                                <x-button variant="outline">
                                    Détails
                                </x-button>
                            </a>
                        </div>
                    </x-carte-properiete>
                @endforeach
            </div>

             @if($properties->hasPages())
                <div class="mt-8">
                    {{ $properties->links() }}
                </div>
            @endif
        @endif
</x-layout>
