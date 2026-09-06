<x-app-layout>
    <div class="min-h-screen bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 py-10">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-10">
                <div>
                    <p class="text-sm font-medium text-indigo-600 mb-2">
                        Espace prestataire
                    </p>

                    <h1 class="text-3xl md:text-4xl font-bold text-slate-900">
                        Bonjour, {{ auth()->user()->prenom }} 👋
                    </h1>

                    <p class="mt-2 text-slate-500">
                        Gérez vos services, réservations et avis depuis votre espace.
                    </p>
                </div>

                <a href="{{ route('services.create') }}"
                   class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">
                    <span>＋</span>
                    Ajouter un service
                </a>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5 mb-10">

                {{-- Services --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm text-slate-500">Mes services</p>
                    <p class="text-3xl font-bold text-slate-900 mt-2">
                        {{ $stats['services'] ?? 0 }}
                    </p>
                    <div class="mt-4 text-2xl">💼</div>
                </div>

                {{-- Pending --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm text-slate-500">En attente</p>
                    <p class="text-3xl font-bold text-amber-600 mt-2">
                        {{ $stats['pending'] ?? 0 }}
                    </p>
                    <div class="mt-4 text-2xl">⏳</div>
                </div>

                {{-- Accepted --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm text-slate-500">Acceptées</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">
                        {{ $stats['accepted'] ?? 0 }}
                    </p>
                    <div class="mt-4 text-2xl">✓</div>
                </div>

                {{-- Completed --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm text-slate-500">Terminées</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-2">
                        {{ $stats['completed'] ?? 0 }}
                    </p>
                    <div class="mt-4 text-2xl">🏆</div>
                </div>

                {{-- Reviews --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm text-slate-500">Avis reçus</p>
                    <p class="text-3xl font-bold text-purple-600 mt-2">
                        {{ $stats['reviews'] ?? 0 }}
                    </p>

                    <div class="mt-3 flex items-center gap-1">
                        <span class="text-yellow-400">★</span>
                        <span class="text-sm font-semibold text-slate-700">
                            {{ number_format($stats['rating'] ?? 0, 1) }}
                        </span>
                    </div>
                </div>

            </div>

            {{-- Main content --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Services --}}
                <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm">

                    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-bold text-slate-900">
                                Mes services
                            </h2>

                            <p class="text-sm text-slate-500 mt-1">
                                Gérez vos services publiés sur Nexora.
                            </p>
                        </div>

                        <a href="{{ route('services.index') }}"
                           class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                            Voir tout →
                        </a>
                    </div>

                    <div class="divide-y divide-slate-100">

                        @forelse ($services ?? [] as $service)

                            <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-5">

                                <div class="flex items-center gap-4">

                                    @if ($service->image)
                                        <img
                                            src="{{ asset('storage/' . $service->image) }}"
                                            alt="{{ $service->titre }}"
                                            class="w-16 h-16 rounded-xl object-cover"
                                        >
                                    @else
                                        <div class="w-16 h-16 rounded-xl bg-indigo-100 flex items-center justify-center text-2xl">
                                            💼
                                        </div>
                                    @endif

                                    <div>
                                        <h3 class="font-semibold text-slate-900">
                                            {{ $service->titre }}
                                        </h3>

                                        <p class="text-sm text-slate-500 mt-1">
                                            {{ $service->category->nom ?? 'Sans catégorie' }}
                                        </p>

                                        <p class="text-sm font-semibold text-indigo-600 mt-1">
                                            {{ number_format($service->prix, 2) }} MAD
                                        </p>
                                    </div>

                                </div>

                                <div class="flex items-center gap-3">

                                    @php
                                        $serviceStatus = match($service->statut) {
                                            'publie' => 'bg-emerald-100 text-emerald-700',
                                            'brouillon' => 'bg-amber-100 text-amber-700',
                                            'suspendu' => 'bg-red-100 text-red-700',
                                            default => 'bg-slate-100 text-slate-600',
                                        };

                                        $serviceStatusLabel = match($service->statut) {
                                            'publie' => 'Publié',
                                            'brouillon' => 'Brouillon',
                                            'suspendu' => 'Suspendu',
                                            default => ucfirst($service->statut),
                                        };
                                    @endphp

                                    <span class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $serviceStatus }}">
                                        {{ $serviceStatusLabel }}
                                    </span>

                                    <a href="{{ route('services.edit', $service) }}"
                                       class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                                        Modifier
                                    </a>

                                </div>

                            </div>

                        @empty

                            <div class="p-12 text-center">

                                <div class="text-4xl mb-4">
                                    💼
                                </div>

                                <h3 class="font-semibold text-slate-900">
                                    Aucun service
                                </h3>

                                <p class="text-sm text-slate-500 mt-2 mb-5">
                                    Commencez par créer votre premier service.
                                </p>

                                <a href="{{ route('services.create') }}"
                                   class="inline-flex px-4 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                                    Créer un service
                                </a>

                            </div>

                        @endforelse

                    </div>
                </div>

                {{-- Quick actions --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

                    <h2 class="text-lg font-bold text-slate-900">
                        Gestion rapide
                    </h2>

                    <p class="text-sm text-slate-500 mt-1 mb-5">
                        Accédez rapidement à vos outils.
                    </p>

                    <div class="space-y-3">

                        <a href="{{ route('services.create') }}"
                           class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 hover:bg-indigo-50 transition group">

                            <span class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-xl">
                                ＋
                            </span>

                            <div>
                                <p class="font-semibold text-slate-900 group-hover:text-indigo-600">
                                    Ajouter un service
                                </p>
                                <p class="text-xs text-slate-500">
                                    Publier une nouvelle offre
                                </p>
                            </div>

                        </a>

                        <a href="{{ route('reservations.index') }}"
                           class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 hover:bg-amber-50 transition group">

                            <span class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center text-xl">
                                📅
                            </span>

                            <div>
                                <p class="font-semibold text-slate-900 group-hover:text-amber-600">
                                    Réservations
                                </p>
                                <p class="text-xs text-slate-500">
                                    Gérer les demandes clients
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
                                    Messages
                                </p>
                                <p class="text-xs text-slate-500">
                                    Communiquer avec vos clients
                                </p>
                            </div>

                        </a>

                        <a href="{{ route('avis.index') }}"
                           class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 hover:bg-purple-50 transition group">

                            <span class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center text-xl">
                                ⭐
                            </span>

                            <div>
                                <p class="font-semibold text-slate-900 group-hover:text-purple-600">
                                    Mes avis
                                </p>
                                <p class="text-xs text-slate-500">
                                    Consultez les retours clients
                                </p>
                            </div>

                        </a>

                        <a href="{{ route('notifications.index') }}"
                           class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 hover:bg-rose-50 transition group">

                            <span class="w-10 h-10 rounded-lg bg-rose-100 flex items-center justify-center text-xl">
                                🔔
                            </span>

                            <div>
                                <p class="font-semibold text-slate-900 group-hover:text-rose-600">
                                    Notifications
                                </p>
                                <p class="text-xs text-slate-500">
                                    Voir vos notifications
                                </p>
                            </div>

                        </a>

                    </div>
                </div>

            </div>

            {{-- CTA --}}
            <div class="mt-6 rounded-2xl bg-slate-900 p-8 text-white flex flex-col md:flex-row md:items-center md:justify-between gap-6">

                <div>
                    <h2 class="text-xl font-bold">
                        Développez votre activité avec Nexora 🚀
                    </h2>

                    <p class="text-slate-300 mt-1">
                        Publiez vos services et trouvez de nouveaux clients.
                    </p>
                </div>

                <a href="{{ route('services.create') }}"
                   class="inline-flex items-center justify-center px-5 py-3 rounded-xl bg-white text-slate-900 font-semibold hover:bg-slate-100 transition">
                    Publier un service →
                </a>

            </div>

        </div>
    </div>
</x-app-layout>