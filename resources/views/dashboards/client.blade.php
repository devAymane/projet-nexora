<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Client Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">
                    Bonjour, {{ auth()->user()->prenom }} 👋
                </h1>
                <p class="text-gray-600 mt-1">
                    Bienvenue sur votre espace client.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <p class="text-sm text-gray-500">Réservations</p>
                    <p class="text-3xl font-bold mt-2">
                        {{ $stats['reservations'] }}
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <p class="text-sm text-gray-500">En attente</p>
                    <p class="text-3xl font-bold mt-2">
                        {{ $stats['pending'] }}
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <p class="text-sm text-gray-500">Terminées</p>
                    <p class="text-3xl font-bold mt-2">
                        {{ $stats['completed'] }}
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <p class="text-sm text-gray-500">Favoris</p>
                    <p class="text-3xl font-bold mt-2">
                        {{ $stats['favorites'] }}
                    </p>
                </div>

            </div>

            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold">
                        Mes dernières réservations
                    </h3>
                </div>

                <div class="divide-y">
                    @forelse($recentReservations as $reservation)
                        <div class="p-6 flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold">
                                    {{ $reservation->service->titre }}
                                </h4>

                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $reservation->date->format('d/m/Y H:i') }}
                                </p>
                            </div>

                            <span class="px-3 py-1 rounded-full text-sm bg-gray-100">
                                {{ ucfirst(str_replace('_', ' ', $reservation->statut)) }}
                            </span>
                        </div>
                    @empty
                        <div class="p-6 text-gray-500">
                            Aucune réservation pour le moment.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>