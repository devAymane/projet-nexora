<x-app-layout>

    <div class="min-h-screen bg-slate-50">

        <main class="px-4 py-8 sm:px-6 lg:px-8">

            <div class="mx-auto max-w-7xl">

                {{-- HEADER --}}
                <div class="mb-8 flex flex-col justify-between gap-5 md:flex-row md:items-end">

                    <div>
                        <p class="mb-2 text-sm font-semibold text-indigo-600">
                            Tableau de bord
                        </p>

                        <h1 class="text-3xl font-black tracking-tight text-slate-900 sm:text-4xl">
                            Bonjour {{ Auth::user()->prenom }} 👋
                        </h1>

                        <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                            Gérez vos services, vos réservations et vos conversations
                            depuis votre espace Nexora.
                        </p>
                    </div>

                    <a href="#"
                       class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-200 transition hover:-translate-y-0.5 hover:bg-indigo-700">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4v16m8-8H4"/>
                        </svg>

                        Ajouter un service
                    </a>

                </div>


                {{-- STATISTICS --}}
                <div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">

                    {{-- Services --}}
                    <div class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">

                        <div class="flex items-start justify-between">

                            <div>
                                <p class="text-sm font-medium text-slate-500">
                                    Mes services
                                </p>

                                <p class="mt-3 text-3xl font-black text-slate-900">
                                    0
                                </p>

                                <p class="mt-2 text-xs text-slate-400">
                                    Services publiés
                                </p>
                            </div>

                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>

                        </div>

                    </div>


                    {{-- Reservations --}}
                    <div class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">

                        <div class="flex items-start justify-between">

                            <div>
                                <p class="text-sm font-medium text-slate-500">
                                    Réservations
                                </p>

                                <p class="mt-3 text-3xl font-black text-slate-900">
                                    0
                                </p>

                                <p class="mt-2 text-xs text-slate-400">
                                    Total des réservations
                                </p>
                            </div>

                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-violet-600 group-hover:bg-violet-600 group-hover:text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>

                        </div>

                    </div>


                    {{-- Favorites --}}
                    <div class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">

                        <div class="flex items-start justify-between">

                            <div>
                                <p class="text-sm font-medium text-slate-500">
                                    Favoris
                                </p>

                                <p class="mt-3 text-3xl font-black text-slate-900">
                                    0
                                </p>

                                <p class="mt-2 text-xs text-slate-400">
                                    Services sauvegardés
                                </p>
                            </div>

                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-pink-50 text-pink-600 group-hover:bg-pink-600 group-hover:text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364 4.318 12.682a4.5 4.5 0 010-6.364z"/>
                                </svg>
                            </div>

                        </div>

                    </div>


                    {{-- Messages --}}
                    <div class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">

                        <div class="flex items-start justify-between">

                            <div>
                                <p class="text-sm font-medium text-slate-500">
                                    Messages
                                </p>

                                <p class="mt-3 text-3xl font-black text-slate-900">
                                    0
                                </p>

                                <p class="mt-2 text-xs text-slate-400">
                                    Conversations
                                </p>
                            </div>

                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 10h8m-8 4h5m-9 7l3.5-3.5A2 2 0 0110.914 17H19a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v9a2 2 0 002 2h1v4z"/>
                                </svg>
                            </div>

                        </div>

                    </div>

                </div>


                {{-- CONTENT GRID --}}
                <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

                    {{-- Activity --}}
                    <div class="xl:col-span-2 rounded-2xl border border-slate-200 bg-white shadow-sm">

                        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">

                            <div>
                                <h2 class="font-bold text-slate-900">
                                    Activité récente
                                </h2>

                                <p class="mt-1 text-xs text-slate-400">
                                    Suivez vos dernières activités.
                                </p>
                            </div>

                            <button class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">
                                Voir tout
                            </button>

                        </div>

                        <div class="flex min-h-[320px] items-center justify-center p-6">

                            <div class="text-center">

                                <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-50">

                                    <svg class="h-8 w-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>

                                </div>

                                <h3 class="font-bold text-slate-900">
                                    Aucune activité récente
                                </h3>

                                <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-slate-500">
                                    Vos réservations, messages et activités
                                    apparaîtront automatiquement ici.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Quick Actions --}}
                    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                        <div class="border-b border-slate-100 px-6 py-5">

                            <h2 class="font-bold text-slate-900">
                                Actions rapides
                            </h2>

                            <p class="mt-1 text-xs text-slate-400">
                                Accédez rapidement aux fonctionnalités.
                            </p>

                        </div>

                        <div class="space-y-3 p-5">

                            <a href="#"
                               class="group flex items-center gap-4 rounded-xl border border-slate-100 p-4 transition hover:border-indigo-200 hover:bg-indigo-50">

                                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-xl font-bold text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white">
                                    +
                                </div>

                                <div>
                                    <p class="text-sm font-semibold text-slate-900">
                                        Ajouter un service
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        Publier une nouvelle offre
                                    </p>
                                </div>

                            </a>


                            <a href="#"
                               class="group flex items-center gap-4 rounded-xl border border-slate-100 p-4 transition hover:border-violet-200 hover:bg-violet-50">

                                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-50 text-violet-600 group-hover:bg-violet-600 group-hover:text-white">

                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>

                                </div>

                                <div>
                                    <p class="text-sm font-semibold text-slate-900">
                                        Explorer les services
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        Trouver un prestataire
                                    </p>
                                </div>

                            </a>


                            <a href="#"
                               class="group flex items-center gap-4 rounded-xl border border-slate-100 p-4 transition hover:border-emerald-200 hover:bg-emerald-50">

                                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white">

                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 10h8m-8 4h5m-9 7l3.5-3.5A2 2 0 0110.914 17H19a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v9a2 2 0 002 2h1v4z"/>
                                    </svg>

                                </div>

                                <div>
                                    <p class="text-sm font-semibold text-slate-900">
                                        Mes messages
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        Consulter mes conversations
                                    </p>
                                </div>

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </main>

    </div>

</x-app-layout>