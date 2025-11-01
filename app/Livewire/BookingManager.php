<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Property;
use Livewire\Attributes\On;

class BookingManager extends Component
{
    protected $listeners = ['close' => 'closeBookingModal'];
    public $search = '';
    public $statusFilter = 'all';
    public $maxPrice = '';
    
    public $selectedProperty = null;
    public $showBookingModal = false;
    
    public $bookingData = [
        'start_date' => '',
        'end_date' => '',
    ];
 
    public function resetFilters()
    {
        $this->search = '';
        $this->statusFilter = 'all';
        $this->maxPrice = '';
        
        $this->dispatch('filters-reset');
    }

    /**
     * Appliquer les filtres
     */
    public function applyFilters()
    {
        $this->dispatch('filters-applied', [
            'search' => $this->search,
            'status' => $this->statusFilter,
            'maxPrice' => $this->maxPrice
        ]);
    }

    
    public function openBookingModal($propertyId)
    {
        $this->selectedProperty = Property::find($propertyId);
        $this->showBookingModal = true;
        $this->resetBookingData();
        
        $this->dispatch('booking-modal-opened');
    }

   
    public function closeBookingModal()
    {
        $this->showBookingModal = false;
        $this->selectedProperty = null;
        $this->resetBookingData();
    }

 
    private function resetBookingData()
    {
        $this->bookingData = [
            'start_date' => '',
            'end_date' => '',
        ];
    }

     
    public function createBooking()
    {
         if (!auth()->check()) {
            session()->flash('error', 'Vous devez être connecté pour réserver.');
            return redirect()->route('login');
        }

        $this->validate([
            'bookingData.start_date' => 'required|date|after_or_equal:today',
            'bookingData.end_date' => 'required|date|after:bookingData.start_date',
        ]);

         $existingBooking = \App\Models\Booking::where('property_id', $this->selectedProperty->id)
            ->where(function($query) {
                $query->whereBetween('check_in', [$this->bookingData['start_date'], $this->bookingData['end_date']])
                      ->orWhereBetween('check_out', [$this->bookingData['start_date'], $this->bookingData['end_date']])
                      ->orWhere(function($q) {
                          $q->where('check_in', '<=', $this->bookingData['start_date'])
                            ->where('check_out', '>=', $this->bookingData['end_date']);
                      });
            })
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($existingBooking) {
            $this->addError('bookingData.start_date', 'Ces dates ne sont pas disponibles.');
            return;
        }

         $checkIn = \Carbon\Carbon::parse($this->bookingData['start_date']);
        $checkOut = \Carbon\Carbon::parse($this->bookingData['end_date']);
        $days = $checkIn->diffInDays($checkOut);
        $totalPrice = $this->selectedProperty->price_per_night * $days;

         \App\Models\Booking::create([
            'user_id' => auth()->id(),
            'property_id' => $this->selectedProperty->id,
            'check_in' => $this->bookingData['start_date'],
            'check_out' => $this->bookingData['end_date'],
            'total_price' => $totalPrice,
            'status' => 'confirmed',
        ]);

        session()->flash('message', 'Réservation créée avec succès !');
        
        $this->dispatch('booking-created', [
            'property' => $this->selectedProperty->name
        ]);
        
        $this->closeBookingModal();
    }

   
    #[On('property-deleted')]
    public function handlePropertyDeleted($propertyId)
    {
        session()->flash('message', 'Propriété supprimée avec succès.');
    }

    
    public function getPropertiesProperty()
    {
        $query = Property::query();

         if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

         if ($this->maxPrice) {
            $query->where('price_per_night', '<=', $this->maxPrice);
        }

        
        return $query->latest()->get();
    }

    public function render()
    {
        return view('livewire.booking-manager', [
            'properties' => $this->properties
        ]);
    }
}
