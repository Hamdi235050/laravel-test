<div>
    <!-- Message de succès -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

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

    <div wire:loading class="text-center py-4">
        <div class="loading-spinner"></div>
        <p class="loading-text">Chargement...</p>
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
            <div class="col-span-full empty-state">
                <x-icons.building class="mx-auto text-gray-400 mb-4" />
                <p class="empty-state-title">Aucune propriété trouvée</p>
                <p class="empty-state-subtitle">Essayez de modifier vos critères de recherche</p>
            </div>
        @endforelse
    </div>

     @if($showBookingModal && $selectedProperty)
        <div class="modal-overlay" wire:click.self="closeBookingModal">
            <div class="modal-container">
                 <div class="modal-header">
                    <h3 class="modal-title">Réserver {{ $selectedProperty->name }}</h3>
                    <x-button variant="outline" wire:click="closeBookingModal" class="modal-close !p-2">
                        <x-icons.close />
                    </x-button>
                </div>

                 <form wire:submit.prevent="createBooking">
                    <div class="space-y-4">
                        <div class="bg-blue-50 p-3 rounded-lg mb-4">
                            <p class="text-sm text-blue-800">
                                <strong>Réservation pour :</strong> {{ auth()->user()->name }} ({{ auth()->user()->email }})
                            </p>
                        </div>

                        <div>
                            <label class="form-label">Date d'arrivée</label>
                            <x-input 
                                type="date" 
                                wire:model.live="bookingData.start_date"
                                min="{{ date('Y-m-d') }}" />
                            @error('bookingData.start_date') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="form-label">Date de départ</label>
                            <x-input 
                                type="date" 
                                wire:model.live="bookingData.end_date"
                                min="{{ $bookingData['start_date'] ?? date('Y-m-d') }}" />
                            @error('bookingData.end_date') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600">Prix par nuit</span>
                                <span class="font-semibold">{{ number_format($selectedProperty->price_per_night, 2) }} €</span>
                            </div>
                            @if($bookingData['start_date'] && $bookingData['end_date'])
                                @php
                                    $days = \Carbon\Carbon::parse($bookingData['start_date'])->diffInDays(\Carbon\Carbon::parse($bookingData['end_date']));
                                @endphp
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-600">Nombre de nuits</span>
                                    <span class="font-semibold">{{ $days }}</span>
                                </div>
                                <div class="flex justify-between text-base font-bold text-primary border-t pt-2 mt-2">
                                    <span>Prix total</span>
                                    <span>{{ number_format($selectedProperty->price_per_night * $days, 2) }} €</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3 mt-6">
                        <x-button type="submit" variant="primary" class="flex-1">
                            Confirmer la réservation
                        </x-button>
                        <x-button type="button" variant="outline" wire:click="closeBookingModal">
                            Annuler
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
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
