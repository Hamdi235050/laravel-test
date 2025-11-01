<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $adminExists = User::where('email', 'admin@admin.com')->exists();

        if (!$adminExists) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
            ]);

            $this->command->info('✅ Utilisateur admin créé avec succès !');
            $this->command->info('📧 Email: admin@admin.com');
            $this->command->info('🔑 Mot de passe: password');
        } else {
            $this->command->warn('⚠️  L\'utilisateur admin existe déjà.');
        }
    }
}
