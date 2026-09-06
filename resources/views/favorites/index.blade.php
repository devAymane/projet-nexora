<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-8">

        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

                <div>

                    <p class="text-sm font-semibold text-indigo-600">
                        Mes favoris
                    </p>

                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                        Services favoris
                    </h1>

                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Retrouvez ici les services que vous souhaitez garder à portée de main.
                    </p>

                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-red-50 text-red-500">

                    <svg
                        class="h-6 w-6"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>

                </div>

            </div>


            {{-- Alerts --}}
            @if(session('success'))

                <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4">

                    <div class="flex items-center gap-3">

                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-green-100 text-green-600">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>

                        </div>

                        <p class="text-sm font-semibold text-green-700">
                            {{ session('success') }}
                        </p>

                    </div>

                </div>

            @endif


            @if(session('error'))

                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4">

                    <div class="flex items-center gap-3">

                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-red-100 text-red-600">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-width="2"
                                    d="M12 9v4m0 4h.01"
                                />
                            </svg>

                        </div>

                        <p class="text-sm font-semibold text-red-700">
                            {{ session('error') }}
                        </p>

                    </div>

                </div>

            @endif


            {{-- Counter --}}
            <div class="mb-6 rounded-2xl border border-slate-200 bg-white px-6 py-5 shadow-sm">

                <div class="flex items-center justify-between gap-4">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Vos services enregistrés
                        </p>

                        <p class="mt-1 text-2xl font-bold text-slate-900">
                            {{ $favorites->count() }}
                        </p>

                    </div>

                    <div class="hidden text-right sm:block">

                        <p class="text-xs text-slate-400">
                            Gardez vos services préférés
                        </p>

                        <p class="mt-1 text-sm font-semibold text-indigo-600">
                            Nexora Marketplace
                        </p>

                    </div>

                </div>

            </div>


            {{-- Favorites --}}
            @if($favorites->count())

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

                    @foreach($favorites as $favorite)

                        @php
                            $service = $favorite->service;
                        @endphp

                        @if($service)

                            <article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg">

                                {{-- Image --}}
                                <div class="relative h-52 overflow-hidden bg-slate-100">

                                    @if($service->image)

                                        <img
                                            src="{{ asset('storage/' . $service->image) }}"
                                            alt="{{ $service->titre }}"
                                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                        >

                                    @else

                                        <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-indigo-50 to-slate-100">

                                            <svg
                                                class="h-14 w-14 text-indigo-200"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M4 16l4-4 4 4 4-5 4 5M5 20h14a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v14a1 1 0 001 1z"
                                                />
                                            </svg>

                                        </div>

                                    @endif


                                    {{-- Favorite --}}
                                    <div class="absolute right-4 top-4">

                                        <form
                                            method="POST"
                                            action="{{ route('favorites.destroy', $service) }}"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                title="Retirer des favoris"
                                                class="flex h-10 w-10 items-center justify-center rounded-full bg-white/95 text-red-500 shadow-md backdrop-blur transition hover:bg-red-50"
                                            >

                                                <svg
                                                    class="h-5 w-5"
                                                    fill="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                                </svg>

                                            </button>

                                        </form>

                                    </div>


                                    {{-- Availability --}}
                                    <div class="absolute bottom-4 left-4">

                                        @if($service->disponibilite)

                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-green-500 px-3 py-1.5 text-xs font-semibold text-white shadow-sm">

                                                <span class="h-1.5 w-1.5 rounded-full bg-white"></span>

                                                Disponible

                                            </span>

                                        @else

                                            <span class="inline-flex items-center rounded-full bg-slate-700 px-3 py-1.5 text-xs font-semibold text-white shadow-sm">
                                                Indisponible
                                            </span>

                                        @endif

                                    </div>

                                </div>


                                {{-- Content --}}
                                <div class="p-5">

                                    {{-- Category --}}
                                    @if($service->category)

                                        <span class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700">
                                            {{ $service->category->nom }}
                                        </span>

                                    @endif


                                    {{-- Title --}}
                                    <h2 class="mt-3 line-clamp-2 text-lg font-bold text-slate-900 transition group-hover:text-indigo-600">
                                        {{ $service->titre }}
                                    </h2>


                                    {{-- Description --}}
                                    <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-500">
                                        {{ $service->description }}
                                    </p>


                                    {{-- Provider --}}
                                    <div class="mt-5 flex items-center gap-3 border-t border-slate-100 pt-4">

                                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700">

                                            {{ strtoupper(substr($service->user?->prenom ?? 'P', 0, 1)) }}

                                        </div>

                                        <div class="min-w-0 flex-1">

                                            <p class="truncate text-sm font-semibold text-slate-800">

                                                {{ $service->user?->prenom }}
                                                {{ $service->user?->nom }}

                                            </p>

                                            <p class="text-xs text-slate-400">

                                                {{ $service->ville ?? 'Maroc' }}

                                            </p>

                                        </div>

                                    </div>


                                    {{-- Bottom --}}
                                    <div class="mt-5 flex items-center justify-between gap-3">

                                        <div>

                                            <p class="text-xs text-slate-400">
                                                À partir de
                                            </p>

                                            <p class="text-xl font-bold text-slate-900">

                                                {{ number_format($service->prix, 2, ',', ' ') }}

                                                <span class="text-sm font-medium text-slate-500">
                                                    DH
                                                </span>

                                            </p>

                                        </div>


                                        <a
                                            href="{{ route('services.show', $service) }}"
                                            class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                                        >

                                            Voir

                                            <svg
                                                class="h-4 w-4"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M9 5l7 7-7 7"
                                                />
                                            </svg>

                                        </a>

                                    </div>

                                </div>

                            </article>

                        @endif

                    @endforeach

                </div>


                {{-- Pagination --}}
                @if(method_exists($favorites, 'hasPages') && $favorites->hasPages())

                    <div class="mt-8">
                        {{ $favorites->links() }}
                    </div>

                @endif

            @else

                {{-- Empty state --}}
                <div class="rounded-2xl border border-slate-200 bg-white px-6 py-16 text-center shadow-sm">

                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-red-50 text-red-400">

                        <svg
                            class="h-10 w-10"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>

                    </div>


                    <h2 class="mt-6 text-xl font-bold text-slate-900">
                        Aucun favori pour le moment
                    </h2>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                        Explorez les services disponibles et ajoutez vos préférés pour les retrouver facilement.
                    </p>


                    <a
                        href="{{ route('services.index') }}"
                        class="mt-6 inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700"
                    >

                        Découvrir les services

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M9 5l7 7-7 7"
                            />
                        </svg>

                    </a>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>