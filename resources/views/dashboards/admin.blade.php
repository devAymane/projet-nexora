<x-app-layout>
    <div class="min-h-screen bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="mb-2 flex items-center gap-2 text-sm text-slate-500">
                        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600">
                            Dashboard
                        </a>
                        <span>/</span>
                        <span class="text-slate-700">Administration</span>
                    </div>

                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                        Dashboard Admin
                    </h1>

                    <p class="mt-1 text-slate-500">
                        Gérez et supervisez l'ensemble de la plateforme Nexora.
                    </p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('users.index') }}"
                       class="inline-flex items-center rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-slate-200 transition hover:bg-slate-50">
                        👥 Utilisateurs
                    </a>

                    <a href="{{ route('categories.index') }}"
                       class="inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                        📂 Catégories
                    </a>
                </div>
            </div>

            {{-- Stats --}}
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

                {{-- Users --}}
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">
                                Utilisateurs
                            </p>

                            <p class="mt-2 text-3xl font-bold text-slate-900">
                                {{ $stats['users'] ?? 0 }}
                            </p>

                            <p class="mt-2 text-xs text-slate-500">
                                Membres inscrits
                            </p>
                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-xl">
                            👥
                        </div>
                    </div>
                </div>

                {{-- Services --}}
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">
                                Services
                            </p>

                            <p class="mt-2 text-3xl font-bold text-slate-900">
                                {{ $stats['services'] ?? 0 }}
                            </p>

                            <p class="mt-2 text-xs text-slate-500">
                                Services publiés
                            </p>
                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-xl">
                            💼
                        </div>
                    </div>
                </div>

                {{-- Reservations --}}
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">
                                Réservations
                            </p>

                            <p class="mt-2 text-3xl font-bold text-slate-900">
                                {{ $stats['reservations'] ?? 0 }}
                            </p>

                            <p class="mt-2 text-xs text-slate-500">
                                Total des réservations
                            </p>
                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-xl">
                            📅
                        </div>
                    </div>
                </div>

                {{-- Reviews --}}
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">
                                Avis
                            </p>

                            <p class="mt-2 text-3xl font-bold text-slate-900">
                                {{ $stats['avis'] ?? 0 }}
                            </p>

                            <p class="mt-2 text-xs text-slate-500">
                                Avis déposés
                            </p>
                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-yellow-50 text-xl">
                            ⭐
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main content --}}
            <div class="mt-8 grid gap-6 lg:grid-cols-3">

                {{-- Quick actions --}}
                <div class="lg:col-span-2 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-slate-900">
                            Gestion de la plateforme
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Accédez rapidement aux principales fonctionnalités d'administration.
                        </p>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">

                        {{-- Users --}}
                        <a href="{{ route('users.index') }}"
                           class="group rounded-2xl border border-slate-200 p-5 transition hover:border-indigo-200 hover:bg-indigo-50/40">

                            <div class="flex items-start gap-4">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-100 text-xl">
                                    👥
                                </div>

                                <div>
                                    <h3 class="font-semibold text-slate-900 group-hover:text-indigo-600">
                                        Utilisateurs
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Gérer les comptes, profils et rôles.
                                    </p>
                                </div>
                            </div>
                        </a>

                        {{-- Categories --}}
                        <a href="{{ route('categories.index') }}"
                           class="group rounded-2xl border border-slate-200 p-5 transition hover:border-purple-200 hover:bg-purple-50/40">

                            <div class="flex items-start gap-4">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-purple-100 text-xl">
                                    📂
                                </div>

                                <div>
                                    <h3 class="font-semibold text-slate-900 group-hover:text-purple-600">
                                        Catégories
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Organiser les catégories de services.
                                    </p>
                                </div>
                            </div>
                        </a>

                        {{-- Services --}}
                        <a href="{{ route('services.index') }}"
                           class="group rounded-2xl border border-slate-200 p-5 transition hover:border-blue-200 hover:bg-blue-50/40">

                            <div class="flex items-start gap-4">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-xl">
                                    💼
                                </div>

                                <div>
                                    <h3 class="font-semibold text-slate-900 group-hover:text-blue-600">
                                        Services
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Superviser les services publiés.
                                    </p>
                                </div>
                            </div>
                        </a>

                        {{-- Reservations --}}
                        <a href="{{ route('reservations.index') }}"
                           class="group rounded-2xl border border-slate-200 p-5 transition hover:border-amber-200 hover:bg-amber-50/40">

                            <div class="flex items-start gap-4">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-xl">
                                    📅
                                </div>

                                <div>
                                    <h3 class="font-semibold text-slate-900 group-hover:text-amber-600">
                                        Réservations
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Consulter et superviser les réservations.
                                    </p>
                                </div>
                            </div>
                        </a>

                        {{-- Reviews --}}
                        <a href="{{ route('avis.index') }}"
                           class="group rounded-2xl border border-slate-200 p-5 transition hover:border-yellow-200 hover:bg-yellow-50/40">

                            <div class="flex items-start gap-4">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-yellow-100 text-xl">
                                    ⭐
                                </div>

                                <div>
                                    <h3 class="font-semibold text-slate-900 group-hover:text-yellow-600">
                                        Avis
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Consulter les évaluations des utilisateurs.
                                    </p>
                                </div>
                            </div>
                        </a>

                        {{-- Notifications --}}
                        <a href="{{ route('notifications.index') }}"
                           class="group rounded-2xl border border-slate-200 p-5 transition hover:border-pink-200 hover:bg-pink-50/40">

                            <div class="flex items-start gap-4">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-pink-100 text-xl">
                                    🔔
                                </div>

                                <div>
                                    <h3 class="font-semibold text-slate-900 group-hover:text-pink-600">
                                        Notifications
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Consulter vos notifications.
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Admin info --}}
                <div class="rounded-2xl bg-slate-900 p-6 text-white shadow-sm">

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/10 text-xl">
                        🛡️
                    </div>

                    <h2 class="mt-6 text-xl font-bold">
                        Espace Administrateur
                    </h2>

                    <p class="mt-3 text-sm leading-6 text-slate-300">
                        Depuis cet espace, vous pouvez gérer les utilisateurs,
                        les catégories, les services, les réservations et les avis
                        de la plateforme Nexora.
                    </p>

                    <div class="mt-6 space-y-3">

                        <div class="flex items-center gap-3 text-sm text-slate-300">
                            <span class="text-green-400">✓</span>
                            Gestion des utilisateurs
                        </div>

                        <div class="flex items-center gap-3 text-sm text-slate-300">
                            <span class="text-green-400">✓</span>
                            Gestion des catégories
                        </div>

                        <div class="flex items-center gap-3 text-sm text-slate-300">
                            <span class="text-green-400">✓</span>
                            Supervision des services
                        </div>

                        <div class="flex items-center gap-3 text-sm text-slate-300">
                            <span class="text-green-400">✓</span>
                            Suivi des réservations
                        </div>

                        <div class="flex items-center gap-3 text-sm text-slate-300">
                            <span class="text-green-400">✓</span>
                            Modération des avis
                        </div>

                    </div>
                </div>
            </div>

            {{-- Bottom CTA --}}
            <div class="mt-6 overflow-hidden rounded-2xl bg-indigo-600 p-6 shadow-sm">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h2 class="text-lg font-bold text-white">
                            Besoin de superviser la plateforme ?
                        </h2>

                        <p class="mt-1 text-sm text-indigo-100">
                            Accédez aux outils d'administration de Nexora.
                        </p>
                    </div>

                    <a href="{{ route('users.index') }}"
                       class="inline-flex items-center justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-indigo-600 transition hover:bg-indigo-50">
                        Gérer les utilisateurs →
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>