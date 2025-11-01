@props(['active' => '', 'title' => 'Gestion de Réservations'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50">
     <x-navbar :active="$active" />

    <!-- Contenu principal -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-600">
            <p>© {{ date('Y') }} Gestion de Réservations. Tous droits réservés.</p>
            <p class="text-sm mt-2 text-gray-500">
                <a href="/admin" class="hover:text-primary">Accès Admin</a> | 
                <a href="/bookings" class="hover:text-primary">Mes Réservations</a>
            </p>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
