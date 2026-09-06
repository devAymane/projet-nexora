<x-app-layout>

    <div class="min-h-screen bg-slate-50">

        {{-- HERO --}}
        <section class="bg-white border-b border-slate-200">

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">

                <div class="max-w-3xl">

                    <span class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 text-xs font-bold text-indigo-600">
                        NEXORA MARKETPLACE
                    </span>

                    <h1 class="mt-4 text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl">
                        Trouvez le service
                        <span class="text-indigo-600">qu'il vous faut.</span>
                    </h1>

                    <p class="mt-4 text-lg leading-7 text-slate-500">
                        Découvrez des services proposés par des freelances
                        qualifiés et trouvez le talent idéal pour votre projet.
                    </p>

                </div>


                {{-- SEARCH --}}
                <form
                    method="GET"
                    action="{{ route('services.index') }}"
                    class="mt-8"
                >

                    <div class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-3 shadow-lg shadow-slate-200/50 md:flex-row">

                        <div class="relative flex-1">

                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                🔍
                            </span>

                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Que recherchez-vous ?"
                                class="w-full rounded-xl border-0 bg-slate-50 py-3.5 pl-12 pr-4 text-sm text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-indigo-500"
                            >

                        </div>

                        <button
                            type="submit"
                            class="rounded-xl bg-indigo-600 px-8 py-3.5 text-sm font-bold text-white transition hover:bg-indigo-700"
                        >
                            Rechercher
                        </button>

                    </div>

                </form>

            </div>

        </section>


        {{-- MAIN --}}
        <main class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

            {{-- FLASH MESSAGES --}}
            @if(session('success'))

                <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                    <span>✓</span>
                    {{ session('success') }}
                </div>

            @endif


            @if($errors->any())

                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">

                    <ul class="list-disc space-y-1 pl-5">

                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            @endif


            <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">


                {{-- FILTERS --}}
                <aside class="lg:col-span-1">

                    <div class="sticky top-24 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                        <div class="flex items-center justify-between">

                            <h2 class="text-lg font-bold text-slate-900">
                                Filtres
                            </h2>

                            <a
                                href="{{ route('services.index') }}"
                                class="text-xs font-semibold text-indigo-600 hover:text-indigo-700"
                            >
                                Réinitialiser
                            </a>

                        </div>


                        <form
                            method="GET"
                            action="{{ route('services.index') }}"
                            class="mt-6 space-y-6"
                        >

                            {{-- Search --}}
                            <div>

                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Recherche
                                </label>

                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Ex: site web..."
                                    class="w-full rounded-xl border-slate-300 px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >

                            </div>


                            {{-- Category --}}
                            <div>

                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Catégorie
                                </label>

                                <select
                                    name="category"
                                    class="w-full rounded-xl border-slate-300 px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >

                                    <option value="">
                                        Toutes les catégories
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


                            {{-- Ville --}}
                            <div>

                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Ville
                                </label>

                                <select
                                    name="ville"
                                    class="w-full rounded-xl border-slate-300 px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >

                                    <option value="">
                                        Toutes les villes
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


                            {{-- Price --}}
                            <div>

                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Prix
                                </label>

                                <div class="grid grid-cols-2 gap-3">

                                    <input
                                        type="number"
                                        name="prix_min"
                                        value="{{ request('prix_min') }}"
                                        min="0"
                                        step="0.01"
                                        placeholder="Min"
                                        class="w-full rounded-xl border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >

                                    <input
                                        type="number"
                                        name="prix_max"
                                        value="{{ request('prix_max') }}"
                                        min="0"
                                        step="0.01"
                                        placeholder="Max"
                                        class="w-full rounded-xl border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >

                                </div>

                            </div>


                            <button
                                type="submit"
                                class="w-full rounded-xl bg-slate-900 px-4 py-3 text-sm font-bold text-white transition hover:bg-slate-700"
                            >
                                Appliquer les filtres
                            </button>

                        </form>

                    </div>

                </aside>


                {{-- SERVICES --}}
                <section class="lg:col-span-3">


                    {{-- TOP BAR --}}
                    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                        <div>

                            <p class="text-sm text-slate-500">
                                {{ $services->total() }}
                                {{ $services->total() > 1 ? 'services disponibles' : 'service disponible' }}
                            </p>

                            @if(request('search') || request('category') || request('ville') || request('prix_min') || request('prix_max'))

                                <p class="mt-1 text-xs text-indigo-600">
                                    Résultats filtrés selon vos critères
                                </p>

                            @endif

                        </div>


                        @auth

                            @if(auth()->user()->hasRole('provider'))

                                <a
                                    href="{{ route('services.create') }}"
                                    class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-indigo-700"
                                >
                                    + Ajouter un service
                                </a>

                            @endif

                        @endauth

                    </div>


                    @if($services->count())


                        {{-- GRID --}}
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">

                            @foreach($services as $service)

                                <article
                                    class="group flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl"
                                >

                                    {{-- IMAGE --}}
                                    <a
                                        href="{{ route('services.show', $service) }}"
                                        class="block"
                                    >

                                        <div class="relative h-52 overflow-hidden bg-slate-100">

                                            @if($service->image)

                                                <img
                                                    src="{{ asset('storage/' . $service->image) }}"
                                                    alt="{{ $service->titre }}"
                                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                                >

                                            @else

                                                <div class="flex h-full items-center justify-center bg-gradient-to-br from-indigo-50 to-purple-50">

                                                    <div class="text-center">

                                                        <div class="text-4xl">
                                                            💼
                                                        </div>

                                                        <p class="mt-2 text-xs font-semibold text-slate-400">
                                                            Service Nexora
                                                        </p>

                                                    </div>

                                                </div>

                                            @endif


                                            {{-- Category --}}
                                            <div class="absolute left-4 top-4">

                                                <span class="inline-flex rounded-full bg-white/95 px-3 py-1.5 text-xs font-bold text-indigo-600 shadow-sm backdrop-blur">
                                                    {{ $service->category->nom }}
                                                </span>

                                            </div>

                                        </div>

                                    </a>


                                    {{-- CONTENT --}}
                                    <div class="flex flex-1 flex-col p-5">


                                        {{-- TITLE --}}
                                        <a
                                            href="{{ route('services.show', $service) }}"
                                            class="text-lg font-bold leading-6 text-slate-900 transition hover:text-indigo-600"
                                        >
                                            {{ $service->titre }}
                                        </a>


                                        {{-- DESCRIPTION --}}
                                        <p class="mt-2 line-clamp-3 text-sm leading-6 text-slate-500">
                                            {{ $service->description }}
                                        </p>


                                        {{-- PROVIDER --}}
                                        <div class="mt-5 flex items-center gap-3">

                                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 font-bold text-indigo-600">

                                                {{ strtoupper(substr($service->user->prenom, 0, 1)) }}

                                            </div>

                                            <div class="min-w-0">

                                                <p class="text-xs text-slate-400">
                                                    Prestataire
                                                </p>

                                                <p class="truncate text-sm font-semibold text-slate-700">
                                                    {{ $service->user->prenom }}
                                                    {{ $service->user->nom }}
                                                </p>

                                            </div>

                                        </div>


                                        {{-- LOCATION --}}
                                        <div class="mt-3 text-sm text-slate-500">
                                            📍 {{ $service->ville }}
                                        </div>


                                        <div class="flex-1"></div>


                                        {{-- PRICE --}}
                                        <div class="mt-5 flex items-end justify-between border-t border-slate-100 pt-4">

                                            <div>

                                                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                                    À partir de
                                                </p>

                                                <p class="mt-1 text-2xl font-bold text-indigo-600">
                                                    {{ number_format($service->prix, 2, ',', ' ') }}
                                                    <span class="text-sm font-semibold">
                                                        DH
                                                    </span>
                                                </p>

                                            </div>

                                        </div>


                                        {{-- ACTIONS --}}
                                        <div class="mt-4 space-y-2">

                                            <a
                                                href="{{ route('services.show', $service) }}"
                                                class="flex w-full items-center justify-center rounded-xl bg-slate-900 px-4 py-3 text-sm font-bold text-white transition hover:bg-slate-700"
                                            >
                                                Voir le service →
                                            </a>


                                            {{-- FAVORITE --}}
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
                                                                class="flex w-full items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-600"
                                                            >
                                                                ♡ Ajouter aux favoris
                                                            </button>

                                                        </form>

                                                    @endif

                                                @endif

                                            @endauth


                                            {{-- OWNER / ADMIN --}}
                                            @auth

                                                @if(auth()->id() === $service->user_id || auth()->user()->hasRole('admin'))

                                                    <div class="grid grid-cols-2 gap-2">

                                                        <a
                                                            href="{{ route('services.edit', $service) }}"
                                                            class="flex items-center justify-center rounded-xl bg-indigo-600 px-3 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                                                        >
                                                            Modifier
                                                        </a>


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


                        {{-- PAGINATION --}}
                        @if($services->hasPages())

                            <div class="mt-10">
                                {{ $services->links() }}
                            </div>

                        @endif


                    @else

                        {{-- EMPTY STATE --}}
                        <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-20 text-center">

                            <div class="mx-auto max-w-md">

                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-50 text-3xl">
                                    🔍
                                </div>

                                <h2 class="mt-5 text-2xl font-bold text-slate-900">
                                    Aucun service trouvé
                                </h2>

                                <p class="mt-2 text-sm leading-6 text-slate-500">
                                    Aucun service ne correspond à vos critères.
                                    Essayez de modifier vos filtres ou votre recherche.
                                </p>

                                <a
                                    href="{{ route('services.index') }}"
                                    class="mt-6 inline-flex items-center justify-center rounded-xl bg-indigo-600 px-6 py-3 text-sm font-bold text-white transition hover:bg-indigo-700"
                                >
                                    Voir tous les services
                                </a>

                            </div>

                        </div>

                    @endif

                </section>

            </div>

        </main>

    </div>

</x-app-layout>