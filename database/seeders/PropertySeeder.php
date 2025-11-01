<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $properties = [
            [
                'name' => 'Villa de Luxe avec Piscine',
                'description' => 'Magnifique villa moderne avec piscine privée, jardin luxuriant et vue panoramique. Idéale pour des vacances en famille.',
                'price_per_night' => 250.00,
                'image' => 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=800',
            ],
            [
                'name' => 'Appartement Centre-Ville',
                'description' => 'Appartement moderne situé en plein cœur de la ville, proche de toutes commodités. Parfait pour un séjour urbain.',
                'price_per_night' => 120.00,
                'image' => 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=800',
            ],
            [
                'name' => 'Chalet Montagne',
                'description' => 'Charmant chalet en bois avec vue imprenable sur les montagnes. Ambiance chaleureuse et authentique.',
                'price_per_night' => 180.00,
                'image' => 'https://images.unsplash.com/photo-1518780664697-55e3ad937233?w=800',
            ],
            [
                'name' => 'Studio Cosy',
                'description' => 'Studio confortable et bien équipé, idéal pour un court séjour ou un voyage d\'affaires.',
                'price_per_night' => 75.00,
                'image' => 'https://images.unsplash.com/photo-1502672260066-6bc35f0ea4a8?w=800',
            ],
            [
                'name' => 'Maison de Campagne',
                'description' => 'Maison rustique entourée de nature, parfaite pour se ressourcer loin de l\'agitation urbaine.',
                'price_per_night' => 150.00,
                'image' => 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800',
            ],
            [
                'name' => 'Penthouse Vue Mer',
                'description' => 'Luxueux penthouse avec terrasse panoramique et vue spectaculaire sur l\'océan.',
                'price_per_night' => 350.00,
                'image' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800',
            ],
        ];

        foreach ($properties as $property) {
            Property::create($property);
        }

        $this->command->info('✅ ' . count($properties) . ' propriétés créées avec succès !');
    }
}
