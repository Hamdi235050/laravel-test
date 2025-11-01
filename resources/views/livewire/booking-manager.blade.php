<div>
    <x-alert />

    <div class="page-header">
        <h1 class="page-title">Gestion des Réservations</h1>
        <p class="page-subtitle">Découvrez et réservez nos propriétés disponibles</p>
    </div>

     <div class="card p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <x-input 
                type="text" 
                wire:model.live.debounce.300ms="search"
                placeholder="Rechercher..." />
            
            <x-select wire:model.live="statusFilter">
                <option value="all">Toutes les propriétés</option>
                <option value="available">Disponibles</option>
                <option value="reserved">Réservées</option>
            </x-select>
            
            <x-input 
                type="number" 
                wire:model.live.debounce.300ms="maxPrice"
                placeholder="Prix max" />
            
            <div class="flex gap-2">
                <x-button variant="primary" class="flex-1" wire:click="applyFilters">
                    Filtrer
                </x-button>
                <x-button variant="outline" wire:click="resetFilters">
                    Réinitialiser
                </x-button>
            </div>
        </div>
    </div>

    <div wire:loading>
        <x-loading-spinner />
    </div>

     <div class="grid-properties" wire:loading.remove>
        @forelse($properties as $property)
            <x-carte-properiete :property="$property">
                <div class="flex gap-3">
                    <x-button 
                        variant="primary" 
                        class="flex-1"
                        wire:click="openBookingModal({{ $property->id }})">
                        Réserver
                    </x-button>
                    <x-button variant="outline">
                        Détails
                    </x-button>
                </div>
            </x-carte-properiete>
        @empty
            <x-empty-state 
                colSpan 
                title="Aucune propriété trouvée" 
                subtitle="Essayez de modifier vos critères de recherche" />
        @endforelse
    </div>

    <!-- Modal de réservation -->
    @if($showBookingModal && $selectedProperty)
        <x-modal-booking 
            :show="$showBookingModal"
            :property="$selectedProperty"
            :bookingData="$bookingData"
            wire:close="closeBookingModal" />
    @endif
</div>

@script
<script>
    $wire.on('filters-applied', (data) => {
        console.log('Filtres appliqués:', data);
    });

    $wire.on('booking-created', (data) => {
        console.log('Réservation créée pour:', data.property);
    });

    $wire.on('filters-reset', () => {
        console.log('Filtres réinitialisés');
    });
</script>
@endscript
