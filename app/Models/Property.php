<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price_per_night',
        'image',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

   
    public function hasActiveBooking()
    {
        return $this->bookings()
            ->where('status', '!=', 'cancelled')
            ->where(function($query) {
                $query->where('check_out', '>=', now())
                      ->where('check_in', '<=', now());
            })
            ->exists();
    }


    public function hasFutureBookings()
    {
        return $this->bookings()
            ->where('status', '!=', 'cancelled')
            ->where('check_in', '>', now())
            ->exists();
    }

    
    public function getAvailabilityStatusAttribute()
    {
        if ($this->hasActiveBooking()) {
            return 'reserved';
        }
        
        if ($this->hasFutureBookings()) {
            return 'booked';
        }
        
        return 'available';
    }
}