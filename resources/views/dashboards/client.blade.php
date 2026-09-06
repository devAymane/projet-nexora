<x-app-layout>
    <div class="min-h-screen bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 py-10">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-10">
                <div>
                    <p class="text-sm font-medium text-indigo-600 mb-2">
                        Espace client
                    </p>

                    <h1 class="text-3xl md:text-4xl font-bold text-slate-900">
                        Bonjour, {{ auth()->user()->prenom }} 👋
                    </h1>

                    <p class="mt-2 text-slate-500">
                        Retrouvez vos activités et gérez vos projets depuis votre espace.
                    </p>
                </div>

                <a href="{{ route('services.index') }}"
                   class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">
                    <span>＋</span>
                    Explorer les services
                </a>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">

                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Réservations</p>
                            <p class="text-3xl font-bold text-slate-900 mt-2">
                                {{ $stats['reservations'] ?? 0 }}
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center text-2xl">
                            📅
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">En attente</p>
                            <p class="text-3xl font-bold text-amber-600 mt-2">
                                {{ $stats['pending'] ?? 0 }}
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center text-2xl">
                            ⏳
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Terminées</p>
                            <p class="text-3xl font-bold text-emerald-600 mt-2">
                                {{ $stats['completed'] ?? 0 }}
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-2xl">
                            ✓
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Favoris</p>
                            <p class="text-3xl font-bold text-rose-600 mt-2">
                                {{ $stats['favorites'] ?? 0 }}
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-rose-100 flex items-center justify-center text-2xl">
                            ♥
                        </div>
                    </div>
                </div>

            </div>

            {{-- Main grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Recent reservations --}}
                <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm">

                    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-bold text-slate-900">
                                Mes dernières réservations
                            </h2>
                            <p class="text-sm text-slate-500 mt-1">
                                Suivez l'état de vos demandes.
                            </p>
                        </div>

                        <a href="{{ route('reservations.index') }}"
                           class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                            Voir tout →
                        </a>
                    </div>

                    <div class="divide-y divide-slate-100">

                        @forelse ($reservations ?? [] as $reservation)

                            <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">

                                <div class="flex items-center gap-4">

                                    <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                                        {{ strtoupper(substr($reservation->service->titre ?? 'S', 0, 1)) }}
                                    </div>

                                    <div>
                                        <h3 class="font-semibold text-slate-900">
                                            {{ $reservation->service->titre ?? 'Service' }}
                                        </h3>

                                        <p class="text-sm text-slate-500 mt-1">
                                            {{ $reservation->date?->format('d/m/Y à H:i') }}
                                        </p>
                                    </div>

                                </div>

                                <div class="flex items-center gap-4">

                                    @php
                                        $statusClasses = match($reservation->statut) {
                                            'en_attente' => 'bg-amber-100 text-amber-700',
                                            'acceptee' => 'bg-blue-100 text-blue-700',
                                            'terminee' => 'bg-emerald-100 text-emerald-700',
                                            'refusee' => 'bg-red-100 text-red-700',
                                            'annulee' => 'bg-slate-100 text-slate-600',
                                            default => 'bg-slate-100 text-slate-600',
                                        };

                                        $statusLabel = match($reservation->statut) {
                                            'en_attente' => 'En attente',
                                            'acceptee' => 'Acceptée',
                                            'terminee' => 'Terminée',
                                            'refusee' => 'Refusée',
                                            'annulee' => 'Annulée',
                                            default => ucfirst($reservation->statut),
                                        };
                                    @endphp

                                    <span class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $statusClasses }}">
                                        {{ $statusLabel }}
                                    </span>

                                    <a href="{{ route('reservations.show', $reservation) }}"
                                       class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                                        Détails
                                    </a>

                                </div>

                            </div>

                        @empty

                            <div class="p-12 text-center">
                                <div class="text-4xl mb-4">📅</div>

                                <h3 class="font-semibold text-slate-900">
                                    Aucune réservation
                                </h3>

                                <p class="text-sm text-slate-500 mt-2 mb-5">
                                    Vous n'avez pas encore effectué de réservation.
                                </p>

                                <a href="{{ route('services.index') }}"
                                   class="inline-flex px-4 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                                    Découvrir les services
                                </a>
                            </div>

                        @endforelse

                    </div>
                </div>

                {{-- Quick actions --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

                    <h2 class="text-lg font-bold text-slate-900">
                        Accès rapide
                    </h2>

                    <p class="text-sm text-slate-500 mt-1 mb-5">
                        Les fonctionnalités principales.
                    </p>

                    <div class="space-y-3">

                        <a href="{{ route('services.index') }}"
                           class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 hover:bg-indigo-50 transition group">
                            <span class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-xl">
                                🔎
                            </span>

                            <div>
                                <p class="font-semibold text-slate-900 group-hover:text-indigo-600">
                                    Rechercher un service
                                </p>
                                <p class="text-xs text-slate-500">
                                    Trouver un prestataire
                                </p>
                            </div>
                        </a>

                        <a href="{{ route('favorites.index') }}"
                           class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 hover:bg-rose-50 transition group">
                            <span class="w-10 h-10 rounded-lg bg-rose-100 flex items-center justify-center text-xl">
                                ♥
                            </span>

                            <div>
                                <p class="font-semibold text-slate-900 group-hover:text-rose-600">
                                    Mes favoris
                                </p>
                                <p class="text-xs text-slate-500">
                                    Services sauvegardés
                                </p>
                            </div>
                        </a>

                        <a href="{{ route('conversations.index') }}"
                           class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 hover:bg-emerald-50 transition group">
                            <span class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center text-xl">
                                💬
                            </span>

                            <div>
                                <p class="font-semibold text-slate-900 group-hover:text-emerald-600">
                                    Mes messages
                                </p>
                                <p class="text-xs text-slate-500">
                                    Contacter les prestataires
                                </p>
                            </div>
                        </a>

                        <a href="{{ route('notifications.index') }}"
                           class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 hover:bg-amber-50 transition group">
                            <span class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center text-xl">
                                🔔
                            </span>

                            <div>
                                <p class="font-semibold text-slate-900 group-hover:text-amber-600">
                                    Notifications
                                </p>
                                <p class="text-xs text-slate-500">
                                    Voir les dernières mises à jour
                                </p>
                            </div>
                        </a>

                    </div>
                </div>

            </div>

            {{-- Bottom CTA --}}
            <div class="mt-6 rounded-2xl bg-indigo-600 p-8 text-white flex flex-col md:flex-row md:items-center md:justify-between gap-6">

                <div>
                    <h2 class="text-xl font-bold">
                        Besoin d'un nouveau service ?
                    </h2>

                    <p class="text-indigo-100 mt-1">
                        Découvrez les meilleurs prestataires disponibles sur Nexora.
                    </p>
                </div>

                <a href="{{ route('services.index') }}"
                   class="inline-flex items-center justify-center px-5 py-3 rounded-xl bg-white text-indigo-600 font-semibold hover:bg-indigo-50 transition">
                    Explorer les services →
                </a>

            </div>

        </div>
    </div>
</x-app-layout>