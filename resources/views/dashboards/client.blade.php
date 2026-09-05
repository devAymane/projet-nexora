<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    Dashboard Client
                </h2>

                <p class="text-sm text-gray-500">
                    Gérez vos réservations, favoris et services.
                </p>
            </div>

            <a href="{{ route('services.index') }}"
               class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                Explorer les services
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">

            {{-- Messages --}}
            @if (session('success'))
                <div class="rounded-lg bg-green-50 p-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="rounded-lg bg-red-50 p-4 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Statistics --}}
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">

                {{-- Reservations --}}
                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        Mes réservations
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $stats['reservations'] }}
                    </p>

                    <a href="{{ route('reservations.index') }}"
                       class="mt-3 inline-block text-sm font-medium text-indigo-600 hover:text-indigo-800">
                        Voir mes réservations →
                    </a>
                </div>

                {{-- Pending --}}
                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        En attente
                    </p>

                    <p class="mt-2 text-3xl font-bold text-yellow-600">
                        {{ $stats['pending'] }}
                    </p>

                    <a href="{{ route('reservations.index') }}"
                       class="mt-3 inline-block text-sm font-medium text-indigo-600 hover:text-indigo-800">
                        Voir →
                    </a>
                </div>

                {{-- Completed --}}
                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        Terminées
                    </p>

                    <p class="mt-2 text-3xl font-bold text-green-600">
                        {{ $stats['completed'] }}
                    </p>

                    <a href="{{ route('reservations.index') }}"
                       class="mt-3 inline-block text-sm font-medium text-indigo-600 hover:text-indigo-800">
                        Voir →
                    </a>
                </div>

                {{-- Favorites --}}
                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        Favoris
                    </p>

                    <p class="mt-2 text-3xl font-bold text-pink-600">
                        {{ $stats['favorites'] }}
                    </p>

                    <a href="{{ route('favorites.index') }}"
                       class="mt-3 inline-block text-sm font-medium text-indigo-600 hover:text-indigo-800">
                        Mes favoris →
                    </a>
                </div>

            </div>

            {{-- Quick actions --}}
            <div class="grid grid-cols-1 gap-5 md:grid-cols-3">

                <a href="{{ route('services.index') }}"
                   class="rounded-xl bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <div class="text-2xl">🔎</div>

                    <h3 class="mt-3 font-semibold text-gray-900">
                        Trouver un service
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Recherchez les services disponibles.
                    </p>
                </a>

                <a href="{{ route('reservations.index') }}"
                   class="rounded-xl bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <div class="text-2xl">📅</div>

                    <h3 class="mt-3 font-semibold text-gray-900">
                        Mes réservations
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Consultez et gérez vos réservations.
                    </p>
                </a>

                <a href="{{ route('favorites.index') }}"
                   class="rounded-xl bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <div class="text-2xl">❤️</div>

                    <h3 class="mt-3 font-semibold text-gray-900">
                        Mes favoris
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Retrouvez vos services favoris.
                    </p>
                </a>

            </div>

            {{-- Recent reservations --}}
            <div class="overflow-hidden rounded-xl bg-white shadow-sm">

                <div class="flex flex-col gap-3 border-b border-gray-200 p-6 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">
                            Mes dernières réservations
                        </h3>

                        <p class="text-sm text-gray-500">
                            Consultez rapidement vos dernières demandes.
                        </p>
                    </div>

                    <a href="{{ route('reservations.index') }}"
                       class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                        Toutes les réservations →
                    </a>

                </div>

                @if ($recentReservations->count())

                    <div class="divide-y divide-gray-200">

                        @foreach ($recentReservations as $reservation)

                            <div class="p-6">

                                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                                    <div>

                                        <div class="flex flex-wrap items-center gap-2">

                                            <h4 class="font-semibold text-gray-900">
                                                {{ $reservation->service->titre }}
                                            </h4>

                                            @if ($reservation->statut === 'en_attente')

                                                <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700">
                                                    En attente
                                                </span>

                                            @elseif ($reservation->statut === 'acceptee')

                                                <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">
                                                    Acceptée
                                                </span>

                                            @elseif ($reservation->statut === 'terminee')

                                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                                    Terminée
                                                </span>

                                            @elseif ($reservation->statut === 'refusee')

                                                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                                    Refusée
                                                </span>

                                            @elseif ($reservation->statut === 'annulee')

                                                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">
                                                    Annulée
                                                </span>

                                            @endif

                                        </div>

                                        <div class="mt-2 space-y-1 text-sm text-gray-500">

                                            <p>
                                                Prestataire :
                                                <span class="font-medium text-gray-700">
                                                    {{ $reservation->service->user->prenom }}
                                                    {{ $reservation->service->user->nom }}
                                                </span>
                                            </p>

                                            <p>
                                                Date :
                                                <span class="font-medium text-gray-700">
                                                    {{ $reservation->date->format('d/m/Y à H:i') }}
                                                </span>
                                            </p>

                                            <p>
                                                Prix :
                                                <span class="font-medium text-gray-700">
                                                    {{ number_format($reservation->service->prix, 2) }} MAD
                                                </span>
                                            </p>

                                        </div>

                                    </div>

                                    <div>

                                        <a href="{{ route('reservations.show', $reservation) }}"
                                           class="inline-flex rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                            Voir détails
                                        </a>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="p-10 text-center">

                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gray-100">
                            <span class="text-2xl">📅</span>
                        </div>

                        <h4 class="mt-4 font-semibold text-gray-900">
                            Aucune réservation
                        </h4>

                        <p class="mt-1 text-sm text-gray-500">
                            Vous n'avez pas encore effectué de réservation.
                        </p>

                        <a href="{{ route('services.index') }}"
                           class="mt-5 inline-flex rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-indigo-700">
                            Découvrir les services
                        </a>

                    </div>

                @endif

            </div>

        </div>
    </div>

</x-app-layout>