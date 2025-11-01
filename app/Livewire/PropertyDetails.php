<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Property;
use App\Models\Booking;

class PropertyDetails extends Component
{
    public $propertyId;
    public $property;

    public function mount($propertyId)
    {
        $this->propertyId = $propertyId;
        $this->property = Property::withCount('bookings')->findOrFail($propertyId);
    }

    public function render()
    {
        return view('livewire.property-details');
    }
}
