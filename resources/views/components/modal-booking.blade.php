@props([
    'show' => false,
    'property',
    'bookingData' => []
])

@if($show)
<div class="modal-overlay" wire:click.self="$dispatch('close')">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Réserver {{ $property->name }}</h3>
            <x-button variant="outline" wire:click="$dispatch('close')" class="modal-close !p-2">
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
                        <span class="font-semibold">{{ number_format($property->price_per_night, 2) }} €</span>
                    </div>
                    @if(isset($bookingData['start_date']) && isset($bookingData['end_date']) && $bookingData['start_date'] && $bookingData['end_date'])
                        @php
                            $days = \Carbon\Carbon::parse($bookingData['start_date'])->diffInDays(\Carbon\Carbon::parse($bookingData['end_date']));
                        @endphp
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Nombre de nuits</span>
                            <span class="font-semibold">{{ $days }}</span>
                        </div>
                        <div class="flex justify-between text-base font-bold text-primary border-t pt-2 mt-2">
                            <span>Prix total</span>
                            <span>{{ number_format($property->price_per_night * $days, 2) }} €</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-3 mt-6">
                <x-button type="submit" variant="primary" class="flex-1">
                    Confirmer la réservation
                </x-button>
                <x-button type="button" variant="outline" wire:click="$dispatch('close')">
                    Annuler
                </x-button>
            </div>
        </form>
    </div>
</div>
@endif
