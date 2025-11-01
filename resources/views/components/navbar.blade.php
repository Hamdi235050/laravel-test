@props(['active' => ''])

<nav class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="/" class="text-2xl font-bold text-primary">
                    Réservations Immobiliers
                </a>
            </div>
            <div class="flex items-center gap-6">
                <a href="/" class="text-gray-700 hover:text-primary transition {{ $active === 'properties' ? 'font-semibold' : '' }}">
                    Propriétés
                </a>
                <a href="/bookings" class="text-gray-700 hover:text-primary transition {{ $active === 'bookings' ? 'font-semibold' : '' }}">
                    Réservations
                </a>
                <a href="/admin" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition">
                    Admin
                </a>
            </div>
        </div>
    </div>
</nav>
