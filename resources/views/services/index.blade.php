<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-8">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                        Services
                    </h1>

                    <p class="mt-2 text-sm text-slate-500">
                        Découvrez les services proposés sur Nexora.
                    </p>
                </div>

                {{-- Add service --}}
                @auth
                    @if(auth()->user()->hasRole('provider'))

                        <a
                            href="{{ route('services.create') }}"
                            class="inline-flex w-full items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 sm:w-auto"
                        >
                            + Ajouter un service
                        </a>

                    @endif
                @endauth

            </div>


            {{-- Success message --}}
            @if(session('success'))

                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                    {{ session('success') }}
                </div>

            @endif


            {{-- Validation errors --}}
            @if($errors->any())

                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

            @endif


            {{-- Search & Filters --}}
            <div class="mb-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <form method="GET" action="{{ route('services.index') }}">

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-5">

                        {{-- Search --}}
                        <div class="lg:col-span-2">

                            <label class="mb-1 block text-sm font-medium text-slate-700">
                                Recherche
                            </label>

                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Rechercher un service..."
                                class="w-full rounded-xl border-slate-300 px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                        </div>


                        {{-- Category --}}
                        <div>

                            <label class="mb-1 block text-sm font-medium text-slate-700">
                                Catégorie
                            </label>

                            <select
                                name="category"
                                class="w-full rounded-xl border-slate-300 px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                                <option value="">
                                    Toutes
                                </option>

                                @foreach($categories as $category)

                                    <option
                                        value="{{ $category->id }}"
                                        @selected(request('category') == $category->id)
                                    >
                                        {{ $category->nom }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- City --}}
                        <div>

                            <label class="mb-1 block text-sm font-medium text-slate-700">
                                Ville
                            </label>

                            <select
                                name="ville"
                                class="w-full rounded-xl border-slate-300 px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                                <option value="">
                                    Toutes
                                </option>

                                @foreach($villes as $ville)

                                    <option
                                        value="{{ $ville }}"
                                        @selected(request('ville') === $ville)
                                    >
                                        {{ $ville }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- Minimum price --}}
                        <div>

                            <label class="mb-1 block text-sm font-medium text-slate-700">
                                Prix minimum
                            </label>

                            <input
                                type="number"
                                name="prix_min"
                                value="{{ request('prix_min') }}"
                                min="0"
                                step="0.01"
                                placeholder="0"
                                class="w-full rounded-xl border-slate-300 px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                        </div>


                        {{-- Maximum price --}}
                        <div>

                            <label class="mb-1 block text-sm font-medium text-slate-700">
                                Prix maximum
                            </label>

                            <input
                                type="number"
                                name="prix_max"
                                value="{{ request('prix_max') }}"
                                min="0"
                                step="0.01"
                                placeholder="2000"
                                class="w-full rounded-xl border-slate-300 px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                        </div>

                    </div>


                    {{-- Filter buttons --}}
                    <div class="mt-5 flex flex-col gap-3 sm:flex-row">

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700"
                        >
                            Rechercher
                        </button>

                        <a
                            href="{{ route('services.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                        >
                            Réinitialiser
                        </a>

                    </div>

                </form>

            </div>


            {{-- Result count --}}
            <div class="mb-5 flex items-center justify-between">

                <p class="text-sm text-slate-500">
                    {{ $services->total() }}
                    {{ $services->total() > 1 ? 'services trouvés' : 'service trouvé' }}
                </p>

            </div>


            {{-- Services --}}
            @if($services->count())

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

                    @foreach($services as $service)

                        <article
                            class="flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg"
                        >

                            {{-- Image --}}
                            <div class="h-48 shrink-0 bg-slate-100">

                                @if($service->image)

                                    <img
                                        src="{{ asset('storage/' . $service->image) }}"
                                        alt="{{ $service->titre }}"
                                        class="h-full w-full object-cover"
                                    >

                                @else

                                    <div class="flex h-full items-center justify-center">

                                        <span class="text-sm font-medium text-slate-400">
                                            Aucune image
                                        </span>

                                    </div>

                                @endif

                            </div>


                            {{-- Content --}}
                            <div class="flex flex-1 flex-col p-5">

                                {{-- Category --}}
                                <div class="mb-3">

                                    <span
                                        class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-600"
                                    >
                                        {{ $service->category->nom }}
                                    </span>

                                </div>


                                {{-- Title --}}
                                <h2 class="line-clamp-2 text-lg font-bold leading-6 text-slate-900">
                                    {{ $service->titre }}
                                </h2>


                                {{-- Description --}}
                                <p class="mt-2 line-clamp-3 text-sm leading-6 text-slate-500">
                                    {{ $service->description }}
                                </p>


                                {{-- Provider --}}
                                <div class="mt-4">

                                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                        Prestataire
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-slate-700">
                                        {{ $service->user->prenom }}
                                        {{ $service->user->nom }}
                                    </p>

                                </div>


                                {{-- City --}}
                                <div class="mt-2">

                                    <p class="text-sm text-slate-500">
                                        📍 {{ $service->ville }}
                                    </p>

                                </div>


                                {{-- Spacer --}}
                                <div class="flex-1"></div>


                                {{-- Price --}}
                                <div class="mt-5 border-t border-slate-100 pt-4">

                                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                        Prix
                                    </p>

                                    <p class="mt-1 text-2xl font-bold text-indigo-600">
                                        {{ number_format($service->prix, 2, ',', ' ') }}

                                        <span class="text-base font-semibold">
                                            DH
                                        </span>
                                    </p>

                                </div>


                                {{-- Actions --}}
                                <div class="mt-4 space-y-2">

                                    {{-- View --}}
                                    <a
                                        href="{{ route('services.show', $service) }}"
                                        class="flex w-full items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700"
                                    >
                                        Voir le service
                                    </a>


                                    {{-- Favorite --}}
                                    @auth
                                        @if(auth()->user()->hasRole('client'))

                                            @php
                                                $isFavorite = auth()->user()
                                                    ->favorites()
                                                    ->where('service_id', $service->id)
                                                    ->exists();
                                            @endphp

                                            @if($isFavorite)

                                                <form
                                                    action="{{ route('favorites.destroy', $service) }}"
                                                    method="POST"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="flex w-full items-center justify-center rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-100"
                                                    >
                                                        ♥ Retirer des favoris
                                                    </button>

                                                </form>

                                            @else

                                                <form
                                                    action="{{ route('favorites.store', $service) }}"
                                                    method="POST"
                                                >
                                                    @csrf

                                                    <button
                                                        type="submit"
                                                        class="flex w-full items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                                                    >
                                                        ♡ Ajouter aux favoris
                                                    </button>

                                                </form>

                                            @endif

                                        @endif
                                    @endauth


                                    {{-- Owner / Admin actions --}}
                                    @auth

                                        @if(auth()->id() === $service->user_id || auth()->user()->hasRole('admin'))

                                            <div class="grid grid-cols-2 gap-2">

                                                {{-- Modifier --}}
                                                <a
                                                    href="{{ route('services.edit', $service) }}"
                                                    class="flex items-center justify-center rounded-xl bg-indigo-600 px-3 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                                                >
                                                    Modifier
                                                </a>


                                                {{-- Supprimer --}}
                                                <form
                                                    action="{{ route('services.destroy', $service) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?');"
                                                >

                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="w-full rounded-xl bg-red-600 px-3 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700"
                                                    >
                                                        Supprimer
                                                    </button>

                                                </form>

                                            </div>

                                        @endif

                                    @endauth

                                </div>

                            </div>

                        </article>

                    @endforeach

                </div>


                {{-- Pagination --}}
                @if($services->hasPages())

                    <div class="mt-8">
                        {{ $services->links() }}
                    </div>

                @endif


            @else

                {{-- Empty state --}}
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center shadow-sm">

                    <div class="mx-auto max-w-md">

                        <div class="mb-4 text-4xl">
                            🔍
                        </div>

                        <h2 class="text-xl font-bold text-slate-900">
                            Aucun service trouvé
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Aucun service ne correspond à vos critères de recherche.
                        </p>

                        <a
                            href="{{ route('services.index') }}"
                            class="mt-6 inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700"
                        >
                            Réinitialiser les filtres
                        </a>

                    </div>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>