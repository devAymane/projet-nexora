<x-app-layout>

    {{-- Header --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">
                    Dashboard
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Bienvenue sur votre espace Nexora.
                </p>
            </div>
        </div>
    </x-slot>

    {{-- Main --}}
    <div class="min-h-screen bg-slate-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Welcome --}}
            <div class="mb-8">
                <div class="bg-gradient-to-r from-indigo-600 to-violet-700 rounded-2xl p-6 sm:p-8 text-white shadow-sm">
                    <div class="max-w-2xl">

                        <p class="text-indigo-100 text-sm font-medium mb-2">
                            Bienvenue 👋
                        </p>

                        <h1 class="text-2xl sm:text-3xl font-bold mb-3">
                            Bonjour {{ Auth::user()->prenom }} !
                        </h1>

                        <p class="text-indigo-100 leading-relaxed">
                            Gérez vos services, vos réservations et vos échanges
                            depuis votre espace Nexora.
                        </p>

                    </div>
                </div>
            </div>

            {{-- Statistics --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

                {{-- Services --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm text-slate-500">
                                Services
                            </p>

                            <p class="mt-2 text-3xl font-bold text-slate-900">
                                0
                            </p>
                        </div>

                        <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>

                    </div>
                </div>

                {{-- Reservations --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm text-slate-500">
                                Réservations
                            </p>

                            <p class="mt-2 text-3xl font-bold text-slate-900">
                                0
                            </p>
                        </div>

                        <div class="w-12 h-12 rounded-xl bg-violet-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>

                    </div>
                </div>

                {{-- Favorites --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm text-slate-500">
                                Favoris
                            </p>

                            <p class="mt-2 text-3xl font-bold text-slate-900">
                                0
                            </p>
                        </div>

                        <div class="w-12 h-12 rounded-xl bg-pink-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364 4.318 12.682a4.5 4.5 0 010-6.364z"/>
                            </svg>
                        </div>

                    </div>
                </div>

                {{-- Messages --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm text-slate-500">
                                Messages
                            </p>

                            <p class="mt-2 text-3xl font-bold text-slate-900">
                                0
                            </p>
                        </div>

                        <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 10h8m-8 4h5m-9 7l3.5-3.5A2 2 0 0110.914 17H19a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v9a2 2 0 002 2h1v4z"/>
                            </svg>
                        </div>

                    </div>
                </div>

            </div>

            {{-- Quick Actions + Recent Activity --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Quick Actions --}}
                <div class="lg:col-span-1 bg-white rounded-2xl border border-slate-200 shadow-sm">

                    <div class="p-6 border-b border-slate-100">
                        <h3 class="text-lg font-semibold text-slate-900">
                            Actions rapides
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Accédez rapidement aux fonctionnalités.
                        </p>
                    </div>

                    <div class="p-6 space-y-3">

                        <a href="#"
                           class="flex items-center gap-4 p-4 rounded-xl border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50 transition">

                            <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                                <span class="text-indigo-600 font-bold">+</span>
                            </div>

                            <div>
                                <p class="font-medium text-slate-900">
                                    Ajouter un service
                                </p>

                                <p class="text-sm text-slate-500">
                                    Publier une nouvelle offre
                                </p>
                            </div>

                        </a>

                        <a href="#"
                           class="flex items-center gap-4 p-4 rounded-xl border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50 transition">

                            <div class="w-10 h-10 rounded-lg bg-violet-100 flex items-center justify-center">
                                <span class="text-violet-600">⌕</span>
                            </div>

                            <div>
                                <p class="font-medium text-slate-900">
                                    Explorer les services
                                </p>

                                <p class="text-sm text-slate-500">
                                    Trouver un prestataire
                                </p>
                            </div>

                        </a>

                        <a href="#"
                           class="flex items-center gap-4 p-4 rounded-xl border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50 transition">

                            <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center">
                                <span class="text-emerald-600">✉</span>
                            </div>

                            <div>
                                <p class="font-medium text-slate-900">
                                    Mes messages
                                </p>

                                <p class="text-sm text-slate-500">
                                    Consulter vos conversations
                                </p>
                            </div>

                        </a>

                    </div>
                </div>

                {{-- Recent Activity --}}
                <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm">

                    <div class="p-6 border-b border-slate-100">
                        <h3 class="text-lg font-semibold text-slate-900">
                            Activité récente
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Les dernières activités de votre compte.
                        </p>
                    </div>

                    <div class="p-6">

                        <div class="flex flex-col items-center justify-center py-12 text-center">

                            <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>

                            <h4 class="font-semibold text-slate-900">
                                Aucune activité récente
                            </h4>

                            <p class="mt-2 text-sm text-slate-500 max-w-sm">
                                Vos réservations, messages et autres activités
                                apparaîtront ici.
                            </p>

                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>

</x-app-layout>