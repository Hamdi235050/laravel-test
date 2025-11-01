<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Property;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalProperties = Property::count();
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $totalRevenue = Booking::where('status', 'confirmed')
            ->orWhere('status', 'completed')
            ->sum('total_price');

        return [
            Stat::make('Total Propriétés', $totalProperties)
                ->description('Propriétés disponibles')
                ->descriptionIcon('heroicon-m-home')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

            Stat::make('Réservations Totales', $totalBookings)
                ->description('Toutes les réservations')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary')
                ->chart([3, 5, 3, 7, 3, 4, 5, 6]),

            Stat::make('En Attente', $pendingBookings)
                ->description('Réservations à confirmer')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->chart([2, 3, 4, 3, 2, 3, 4, 3]),

            Stat::make('Revenu Total', number_format($totalRevenue, 2) . ' €')
                ->description('Réservations confirmées')
                ->descriptionIcon('heroicon-m-currency-euro')
                ->color('success')
                ->chart([5, 7, 8, 10, 12, 15, 17, 20]),
        ];
    }
}
