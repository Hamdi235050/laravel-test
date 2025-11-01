<div>
     @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

     <div class="mb-6">
        <a href="/" class="inline-flex items-center text-gray-600 hover:text-primary transition">
            <x-icons.arrow-left class="mr-2" />
            Retour aux propriétés
        </a>
    </div>

     <div class="bg-white rounded-lg shadow-lg overflow-hidden">
         <div class="h-96 bg-gray-300 relative">
            @if($property->image)
                <img src="{{ $property->image }}" alt="{{ $property->name }}" class="w-full h-full object-cover">
            @else
                <div class="flex items-center justify-center h-full text-gray-500">
                    <x-icons.home size="w-32 h-32" />
                </div>
            @endif
            
            <div class="absolute top-4 right-4">
                <span class="px-4 py-2 text-sm font-semibold rounded-full bg-green-500 text-white shadow-lg">
                    Disponible
                </span>
            </div>
        </div>

        <div class="p-8">
            <div class="flex justify-between items-start mb-6">
                <div class="flex-1">
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ $property->name }}</h1>
                    <div class="flex items-center text-gray-600 mt-2">
                        <x-icons.users class="mr-2" />
                        <span>{{ $property->bookings_count }} réservation(s)</span>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-4xl font-bold text-primary">{{ number_format($property->price_per_night, 2) }} €</div>
                    <div class="text-gray-600 text-sm">par nuit</div>
                </div>
            </div>

            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Description</h2>
                <p class="text-gray-700 leading-relaxed">{{ $property->description }}</p>
            </div>

            <div class="flex gap-4">
                <a href="/" class="flex-1">
                    <x-button variant="outline" class="py-3 w-full">
                        Retour aux propriétés
                    </x-button>
                </a>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                    <div><span class="font-semibold">Ajouté le:</span> {{ $property->created_at->format('d/m/Y') }}</div>
                    <div><span class="font-semibold">Mis à jour le:</span> {{ $property->updated_at->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
