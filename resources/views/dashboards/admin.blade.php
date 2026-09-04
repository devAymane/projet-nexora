<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">
                    Administration 👋
                </h1>
                <p class="text-gray-600 mt-1">
                    Vue globale de la plateforme Nexora.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <p class="text-sm text-gray-500">Utilisateurs</p>
                    <p class="text-3xl font-bold mt-2">
                        {{ $stats['users'] }}
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <p class="text-sm text-gray-500">Services</p>
                    <p class="text-3xl font-bold mt-2">
                        {{ $stats['services'] }}
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <p class="text-sm text-gray-500">Catégories</p>
                    <p class="text-3xl font-bold mt-2">
                        {{ $stats['categories'] }}
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <p class="text-sm text-gray-500">Réservations</p>
                    <p class="text-3xl font-bold mt-2">
                        {{ $stats['reservations'] }}
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <p class="text-sm text-gray-500">Avis</p>
                    <p class="text-3xl font-bold mt-2">
                        {{ $stats['reviews'] }}
                    </p>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>