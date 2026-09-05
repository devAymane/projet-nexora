<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Admin Dashboard
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Gérez et surveillez la plateforme Nexora.
                </p>
            </div>

            <span class="rounded-full bg-gray-900 px-4 py-2 text-sm font-semibold text-white">
                Administrateur
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Welcome --}}
            <div class="mb-8 rounded-2xl bg-gradient-to-r from-gray-900 to-gray-700 p-6 text-white shadow-sm">
                <h3 class="text-xl font-bold">
                    Bienvenue, {{ auth()->user()->prenom }} 👋
                </h3>

                <p class="mt-2 text-sm text-gray-300">
                    Voici un aperçu global de l'activité de Nexora.
                </p>
            </div>


            {{-- Statistics --}}
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-5">

                {{-- Users --}}
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Utilisateurs
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900">
                                {{ $stats['users'] }}
                            </p>
                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-2xl">
                            👥
                        </div>

                    </div>

                    <a href="{{ route('users.index') }}"
                       class="mt-4 inline-block text-sm font-semibold text-blue-600 hover:text-blue-800">
                        Gérer les utilisateurs →
                    </a>
                </div>


                {{-- Services --}}
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Services
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900">
                                {{ $stats['services'] }}
                            </p>
                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-100 text-2xl">
                            🛠️
                        </div>

                    </div>

                    <a href="{{ route('services.index') }}"
                       class="mt-4 inline-block text-sm font-semibold text-purple-600 hover:text-purple-800">
                        Voir les services →
                    </a>
                </div>


                {{-- Categories --}}
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Catégories
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900">
                                {{ $stats['categories'] }}
                            </p>
                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-2xl">
                            📂
                        </div>

                    </div>

                    <a href="{{ route('categories.index') }}"
                       class="mt-4 inline-block text-sm font-semibold text-green-600 hover:text-green-800">
                        Gérer les catégories →
                    </a>
                </div>


                {{-- Reservations --}}
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Réservations
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900">
                                {{ $stats['reservations'] }}
                            </p>
                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-100 text-2xl">
                            📅
                        </div>

                    </div>

                    <a href="{{ route('reservations.index') }}"
                       class="mt-4 inline-block text-sm font-semibold text-orange-600 hover:text-orange-800">
                        Voir les réservations →
                    </a>
                </div>


                {{-- Reviews --}}
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Avis
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900">
                                {{ $stats['reviews'] }}
                            </p>
                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-yellow-100 text-2xl">
                            ⭐
                        </div>

                    </div>

                    <a href="{{ route('avis.index') }}"
                       class="mt-4 inline-block text-sm font-semibold text-yellow-600 hover:text-yellow-800">
                        Voir les avis →
                    </a>
                </div>

            </div>


            {{-- Quick Actions --}}
            <div class="mt-8 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100">

                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-900">
                        Actions rapides
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Accédez rapidement aux principales fonctionnalités d'administration.
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

                    <a href="{{ route('users.index') }}"
                       class="group rounded-xl border border-gray-200 p-5 transition hover:border-blue-300 hover:bg-blue-50">

                        <div class="text-2xl">👥</div>

                        <h4 class="mt-3 font-semibold text-gray-900">
                            Utilisateurs
                        </h4>

                        <p class="mt-1 text-sm text-gray-500">
                            Gérer les comptes et les rôles.
                        </p>

                    </a>


                    <a href="{{ route('categories.index') }}"
                       class="group rounded-xl border border-gray-200 p-5 transition hover:border-green-300 hover:bg-green-50">

                        <div class="text-2xl">📂</div>

                        <h4 class="mt-3 font-semibold text-gray-900">
                            Catégories
                        </h4>

                        <p class="mt-1 text-sm text-gray-500">
                            Ajouter ou modifier les catégories.
                        </p>

                    </a>


                    <a href="{{ route('services.index') }}"
                       class="group rounded-xl border border-gray-200 p-5 transition hover:border-purple-300 hover:bg-purple-50">

                        <div class="text-2xl">🛠️</div>

                        <h4 class="mt-3 font-semibold text-gray-900">
                            Services
                        </h4>

                        <p class="mt-1 text-sm text-gray-500">
                            Consulter les services publiés.
                        </p>

                    </a>


                    <a href="{{ route('reservations.index') }}"
                       class="group rounded-xl border border-gray-200 p-5 transition hover:border-orange-300 hover:bg-orange-50">

                        <div class="text-2xl">📅</div>

                        <h4 class="mt-3 font-semibold text-gray-900">
                            Réservations
                        </h4>

                        <p class="mt-1 text-sm text-gray-500">
                            Consulter les réservations.
                        </p>

                    </a>

                </div>

            </div>


            {{-- Platform Overview --}}
            <div class="mt-8 grid gap-6 lg:grid-cols-2">

                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100">

                    <h3 class="text-lg font-bold text-gray-900">
                        État de la plateforme
                    </h3>

                    <div class="mt-6 space-y-5">

                        <div>
                            <div class="mb-2 flex justify-between text-sm">
                                <span class="text-gray-600">
                                    Utilisateurs
                                </span>

                                <span class="font-semibold text-gray-900">
                                    {{ $stats['users'] }}
                                </span>
                            </div>

                            <div class="h-2 rounded-full bg-gray-100">
                                <div class="h-2 rounded-full bg-blue-500"
                                     style="width: {{ min($stats['users'] * 5, 100) }}%">
                                </div>
                            </div>
                        </div>


                        <div>
                            <div class="mb-2 flex justify-between text-sm">
                                <span class="text-gray-600">
                                    Services
                                </span>

                                <span class="font-semibold text-gray-900">
                                    {{ $stats['services'] }}
                                </span>
                            </div>

                            <div class="h-2 rounded-full bg-gray-100">
                                <div class="h-2 rounded-full bg-purple-500"
                                     style="width: {{ min($stats['services'] * 5, 100) }}%">
                                </div>
                            </div>
                        </div>


                        <div>
                            <div class="mb-2 flex justify-between text-sm">
                                <span class="text-gray-600">
                                    Réservations
                                </span>

                                <span class="font-semibold text-gray-900">
                                    {{ $stats['reservations'] }}
                                </span>
                            </div>

                            <div class="h-2 rounded-full bg-gray-100">
                                <div class="h-2 rounded-full bg-orange-500"
                                     style="width: {{ min($stats['reservations'] * 5, 100) }}%">
                                </div>
                            </div>
                        </div>

                    </div>

                </div>


                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100">

                    <h3 class="text-lg font-bold text-gray-900">
                        Informations
                    </h3>

                    <div class="mt-6 space-y-4">

                        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                            <span class="text-sm text-gray-500">
                                Rôle actuel
                            </span>

                            <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                                Administrateur
                            </span>
                        </div>

                        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                            <span class="text-sm text-gray-500">
                                Utilisateurs inscrits
                            </span>

                            <span class="font-semibold text-gray-900">
                                {{ $stats['users'] }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                            <span class="text-sm text-gray-500">
                                Services disponibles
                            </span>

                            <span class="font-semibold text-gray-900">
                                {{ $stats['services'] }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">
                                Avis clients
                            </span>

                            <span class="font-semibold text-gray-900">
                                {{ $stats['reviews'] }}
                            </span>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>