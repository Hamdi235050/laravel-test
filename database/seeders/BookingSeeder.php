<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Property;
use App\Models\User;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $properties = Property::all();
        $users = User::all();

        if ($properties->isEmpty() || $users->isEmpty()) {
            $this->command->warn('Aucune propriété ou utilisateur trouvé. Assurez-vous d\'exécuter PropertySeeder et AdminUserSeeder d\'abord.');
            return;
        }

        // Créer quelques réservations de test
        
        // 1. Réservation en cours (propriété actuellement réservée)
        if ($properties->count() > 0) {
            Booking::create([
                'user_id' => $users->first()->id,
                'property_id' => $properties->first()->id,
                'check_in' => Carbon::now()->subDays(2),
                'check_out' => Carbon::now()->addDays(3),
                'total_price' => $properties->first()->price_per_night * 5,
                'status' => 'confirmed',
            ]);
        }

        // 2. Réservation future (propriété avec réservation à venir)
        if ($properties->count() > 1) {
            Booking::create([
                'user_id' => $users->first()->id,
                'property_id' => $properties->skip(1)->first()->id,
                'check_in' => Carbon::now()->addDays(7),
                'check_out' => Carbon::now()->addDays(10),
                'total_price' => $properties->skip(1)->first()->price_per_night * 3,
                'status' => 'confirmed',
            ]);
        }

        // 3. Réservation passée (propriété disponible maintenant)
        if ($properties->count() > 2) {
            Booking::create([
                'user_id' => $users->first()->id,
                'property_id' => $properties->skip(2)->first()->id,
                'check_in' => Carbon::now()->subDays(10),
                'check_out' => Carbon::now()->subDays(5),
                'total_price' => $properties->skip(2)->first()->price_per_night * 5,
                'status' => 'confirmed',
            ]);
        }

        // 4. Réservation annulée (ne devrait pas affecter la disponibilité)
        if ($properties->count() > 3) {
            Booking::create([
                'user_id' => $users->first()->id,
                'property_id' => $properties->skip(3)->first()->id,
                'check_in' => Carbon::now()->addDays(5),
                'check_out' => Carbon::now()->addDays(8),
                'total_price' => $properties->skip(3)->first()->price_per_night * 3,
                'status' => 'cancelled',
            ]);
        }

        $this->command->info('Réservations de test créées avec succès!');
    }
}
