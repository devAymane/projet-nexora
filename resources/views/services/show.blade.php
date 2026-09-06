<x-app-layout>

    <div class="min-h-screen bg-slate-50">

        {{-- HEADER / BACK --}}
        <div class="border-b border-slate-200 bg-white">

            <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8">

                <a
                    href="{{ route('services.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-indigo-600"
                >
                    ← Retour aux services
                </a>

            </div>

        </div>


        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">


            {{-- ALERTS --}}
            @if(session('success'))

                <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-green-100">
                        ✓
                    </span>

                    {{ session('success') }}
                </div>

            @endif


            @if(session('error'))

                <div class="mb-6 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-red-100">
                        !
                    </span>

                    {{ session('error') }}
                </div>

            @endif


            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">


                {{-- ================================================= --}}
                {{-- LEFT --}}
                {{-- ================================================= --}}
                <div class="lg:col-span-2 space-y-8">


                    {{-- SERVICE --}}
                    <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">


                        {{-- IMAGE --}}
                        <div class="relative h-72 overflow-hidden bg-slate-100 sm:h-[430px]">

                            @if($service->image)

                                <img
                                    src="{{ asset('storage/' . $service->image) }}"
                                    alt="{{ $service->titre }}"
                                    class="h-full w-full object-cover"
                                >

                            @else

                                <div class="flex h-full items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-purple-50">

                                    <div class="text-center">

                                        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-white text-4xl shadow-sm">
                                            💼
                                        </div>

                                        <p class="mt-4 text-sm font-semibold text-slate-400">
                                            Aucune image disponible
                                        </p>

                                    </div>

                                </div>

                            @endif


                            {{-- Category --}}
                            <div class="absolute left-5 top-5">

                                <span class="rounded-full bg-white/95 px-4 py-2 text-xs font-bold text-indigo-600 shadow-lg backdrop-blur">
                                    {{ $service->category->nom }}
                                </span>

                            </div>


                            {{-- Availability --}}
                            <div class="absolute right-5 top-5">

                                @if($service->disponibilite)

                                    <span class="rounded-full bg-green-500 px-4 py-2 text-xs font-bold text-white shadow-lg">
                                        ● Disponible
                                    </span>

                                @else

                                    <span class="rounded-full bg-red-500 px-4 py-2 text-xs font-bold text-white shadow-lg">
                                        ● Indisponible
                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- CONTENT --}}
                        <div class="p-6 sm:p-8">


                            {{-- META --}}
                            <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-slate-500">

                                <span>
                                    📍 {{ $service->ville }}
                                </span>

                                <span>
                                    •
                                </span>

                                <span>
                                    Publié le {{ $service->created_at->format('d/m/Y') }}
                                </span>

                            </div>


                            {{-- TITLE --}}
                            <h1 class="mt-4 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                                {{ $service->titre }}
                            </h1>


                            {{-- DESCRIPTION --}}
                            <div class="mt-8">

                                <h2 class="text-xl font-bold text-slate-900">
                                    Description
                                </h2>

                                <p class="mt-4 whitespace-pre-line text-sm leading-7 text-slate-600">
                                    {{ $service->description }}
                                </p>

                            </div>


                            {{-- PROVIDER --}}
                            <div class="mt-10 border-t border-slate-100 pt-8">

                                <h2 class="text-xl font-bold text-slate-900">
                                    À propos du prestataire
                                </h2>


                                <div class="mt-5 flex items-center gap-4">

                                    @if($service->user->photo)

                                        <img
                                            src="{{ asset('storage/' . $service->user->photo) }}"
                                            alt="{{ $service->user->prenom }}"
                                            class="h-16 w-16 rounded-2xl object-cover"
                                        >

                                    @else

                                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-100 text-xl font-bold text-indigo-600">
                                            {{ strtoupper(substr($service->user->prenom, 0, 1)) }}
                                        </div>

                                    @endif


                                    <div>

                                        <p class="text-lg font-bold text-slate-900">
                                            {{ $service->user->prenom }}
                                            {{ $service->user->nom }}
                                        </p>

                                        @if($service->user->ville)

                                            <p class="mt-1 text-sm text-slate-500">
                                                📍 {{ $service->user->ville }}
                                            </p>

                                        @endif

                                    </div>

                                </div>


                                @if($service->user->description)

                                    <p class="mt-5 text-sm leading-7 text-slate-500">
                                        {{ $service->user->description }}
                                    </p>

                                @endif

                            </div>


                            {{-- OWNER ACTIONS --}}
                            @auth

                                @if(auth()->id() === $service->user_id || auth()->user()->hasRole('admin'))

                                    <div class="mt-8 flex flex-col gap-3 border-t border-slate-100 pt-8 sm:flex-row">

                                        <a
                                            href="{{ route('services.edit', $service) }}"
                                            class="flex-1 rounded-xl bg-indigo-600 px-5 py-3 text-center text-sm font-bold text-white transition hover:bg-indigo-700"
                                        >
                                            Modifier le service
                                        </a>


                                        <form
                                            action="{{ route('services.destroy', $service) }}"
                                            method="POST"
                                            class="flex-1"
                                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="w-full rounded-xl bg-red-600 px-5 py-3 text-sm font-bold text-white transition hover:bg-red-700"
                                            >
                                                Supprimer
                                            </button>

                                        </form>

                                    </div>

                                @endif

                            @endauth

                        </div>

                    </article>


                    {{-- ================================================= --}}
                    {{-- REVIEWS --}}
                    {{-- ================================================= --}}
                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

                        <div class="flex flex-col gap-5 border-b border-slate-100 pb-6 sm:flex-row sm:items-center sm:justify-between">

                            <div>

                                <span class="text-xs font-bold uppercase tracking-widest text-indigo-600">
                                    Témoignages
                                </span>

                                <h2 class="mt-2 text-2xl font-bold text-slate-900">
                                    Avis clients
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    Découvrez les expériences des clients.
                                </p>

                            </div>


                            @if($service->avis->count() > 0)

                                <div class="rounded-2xl bg-slate-50 px-5 py-3 text-center">

                                    <div class="flex items-center justify-center gap-2">

                                        <span class="text-2xl font-bold text-slate-900">
                                            {{ number_format($service->avis->avg('note'), 1) }}
                                        </span>

                                        <span class="text-xl text-yellow-500">
                                            ★
                                        </span>

                                    </div>

                                    <p class="text-xs text-slate-500">
                                        {{ $service->avis->count() }} avis
                                    </p>

                                </div>

                            @else

                                <span class="rounded-full bg-slate-100 px-4 py-2 text-sm text-slate-500">
                                    Aucun avis
                                </span>

                            @endif

                        </div>


                        @if($service->avis->count() > 0)

                            <div class="divide-y divide-slate-100">

                                @foreach($service->avis as $avis)

                                    <div class="py-6 first:pt-7 last:pb-0">

                                        <div class="flex items-start justify-between gap-4">

                                            <div class="flex items-center gap-3">

                                                @if($avis->user->photo)

                                                    <img
                                                        src="{{ asset('storage/' . $avis->user->photo) }}"
                                                        alt="{{ $avis->user->prenom }}"
                                                        class="h-11 w-11 rounded-full object-cover"
                                                    >

                                                @else

                                                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-indigo-100 font-bold text-indigo-600">
                                                        {{ strtoupper(substr($avis->user->prenom, 0, 1)) }}
                                                    </div>

                                                @endif


                                                <div>

                                                    <p class="font-semibold text-slate-900">
                                                        {{ $avis->user->prenom }}
                                                        {{ $avis->user->nom }}
                                                    </p>

                                                    <p class="text-xs text-slate-400">
                                                        {{ \Carbon\Carbon::parse($avis->date)->format('d/m/Y') }}
                                                    </p>

                                                </div>

                                            </div>


                                            {{-- Stars --}}
                                            <div class="flex gap-0.5 text-sm">

                                                @for($i = 1; $i <= 5; $i++)

                                                    <span class="{{ $i <= $avis->note ? 'text-yellow-400' : 'text-slate-200' }}">
                                                        ★
                                                    </span>

                                                @endfor

                                            </div>

                                        </div>


                                        <p class="mt-4 text-sm leading-7 text-slate-600">
                                            {{ $avis->commentaire }}
                                        </p>

                                    </div>

                                @endforeach

                            </div>

                        @else

                            <div class="py-12 text-center">

                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-50 text-2xl">
                                    ⭐
                                </div>

                                <h3 class="mt-4 font-bold text-slate-900">
                                    Aucun avis pour le moment
                                </h3>

                                <p class="mt-2 text-sm text-slate-500">
                                    Les avis apparaîtront après les réservations terminées.
                                </p>

                            </div>

                        @endif

                    </section>

                </div>


                {{-- ================================================= --}}
                {{-- RIGHT SIDEBAR --}}
                {{-- ================================================= --}}
                <aside class="lg:col-span-1">

                    <div class="sticky top-24 space-y-6">


                        {{-- BOOKING CARD --}}
                        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">

                            <p class="text-sm font-medium text-slate-400">
                                Prix du service
                            </p>

                            <div class="mt-1 flex items-baseline gap-2">

                                <span class="text-4xl font-bold text-indigo-600">
                                    {{ number_format($service->prix, 2, ',', ' ') }}
                                </span>

                                <span class="font-semibold text-slate-500">
                                    DH
                                </span>

                            </div>


                            @auth

                                {{-- CLIENT --}}
                                @if(auth()->user()->hasRole('client'))

                                    @if($service->disponibilite)

                                        <a
                                            href="{{ route('reservations.create', ['service_id' => $service->id]) }}"
                                            class="mt-7 flex w-full items-center justify-center rounded-xl bg-indigo-600 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-indigo-200 transition hover:bg-indigo-700"
                                        >
                                            📅 Réserver ce service
                                        </a>

                                    @else

                                        <div class="mt-7 rounded-xl bg-slate-100 px-5 py-3.5 text-center text-sm font-semibold text-slate-500">
                                            Service indisponible
                                        </div>

                                    @endif


                                    {{-- FAVORITE --}}
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
                                            class="mt-3"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="w-full rounded-xl border border-red-200 bg-red-50 px-5 py-3 text-sm font-bold text-red-600 transition hover:bg-red-100"
                                            >
                                                ♥ Retirer des favoris
                                            </button>

                                        </form>

                                    @else

                                        <form
                                            action="{{ route('favorites.store', $service) }}"
                                            method="POST"
                                            class="mt-3"
                                        >

                                            @csrf

                                            <button
                                                type="submit"
                                                class="w-full rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-600"
                                            >
                                                ♡ Ajouter aux favoris
                                            </button>

                                        </form>

                                    @endif


                                    {{-- CONTACT --}}
                                    @if(auth()->id() !== $service->user_id)

                                        <a
                                            href="{{ route('conversations.create', $service->user) }}"
                                            class="mt-3 flex w-full items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:bg-slate-50"
                                        >
                                            💬 Contacter le prestataire
                                        </a>

                                    @endif

                                @endif


                                {{-- PROVIDER --}}
                                @if(auth()->id() === $service->user_id)

                                    <div class="mt-6 rounded-2xl bg-indigo-50 p-4">

                                        <p class="text-sm font-bold text-indigo-900">
                                            Vous êtes le prestataire
                                        </p>

                                        <p class="mt-1 text-xs leading-5 text-indigo-700">
                                            Vous pouvez gérer votre service depuis cette page.
                                        </p>

                                    </div>

                                @endif

                            @else

                                {{-- GUEST --}}
                                @if($service->disponibilite)

                                    <a
                                        href="{{ route('login') }}"
                                        class="mt-7 flex w-full items-center justify-center rounded-xl bg-indigo-600 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-indigo-200 transition hover:bg-indigo-700"
                                    >
                                        Se connecter pour réserver
                                    </a>

                                    <p class="mt-3 text-center text-xs text-slate-400">
                                        Vous devez être connecté pour réserver.
                                    </p>

                                @endif

                            @endauth

                        </div>


                        {{-- INFORMATION --}}
                        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">

                            <h2 class="text-lg font-bold text-slate-900">
                                Informations
                            </h2>


                            <div class="mt-5 divide-y divide-slate-100">

                                <div class="flex items-center justify-between py-4 first:pt-0">

                                    <span class="text-sm text-slate-500">
                                        Catégorie
                                    </span>

                                    <span class="text-sm font-bold text-slate-700">
                                        {{ $service->category->nom }}
                                    </span>

                                </div>


                                <div class="flex items-center justify-between py-4">

                                    <span class="text-sm text-slate-500">
                                        Ville
                                    </span>

                                    <span class="text-sm font-bold text-slate-700">
                                        {{ $service->ville }}
                                    </span>

                                </div>


                                <div class="flex items-center justify-between py-4">

                                    <span class="text-sm text-slate-500">
                                        Disponibilité
                                    </span>

                                    @if($service->disponibilite)

                                        <span class="text-sm font-bold text-green-600">
                                            Disponible
                                        </span>

                                    @else

                                        <span class="text-sm font-bold text-red-600">
                                            Indisponible
                                        </span>

                                    @endif

                                </div>


                                <div class="flex items-center justify-between py-4 last:pb-0">

                                    <span class="text-sm text-slate-500">
                                        Statut
                                    </span>

                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">
                                        {{ ucfirst($service->statut) }}
                                    </span>

                                </div>

                            </div>

                        </div>


                        {{-- TRUST CARD --}}
                        <div class="rounded-3xl border border-indigo-100 bg-indigo-50 p-6">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-lg shadow-sm">
                                    🛡️
                                </div>

                                <h2 class="font-bold text-indigo-900">
                                    Pourquoi Nexora ?
                                </h2>

                            </div>

                            <ul class="mt-5 space-y-3 text-sm text-indigo-700">

                                <li class="flex gap-2">
                                    <span>✓</span>
                                    Prestataires présents sur la plateforme
                                </li>

                                <li class="flex gap-2">
                                    <span>✓</span>
                                    Réservation simple et rapide
                                </li>

                                <li class="flex gap-2">
                                    <span>✓</span>
                                    Communication directe
                                </li>

                            </ul>

                        </div>

                    </div>

                </aside>

            </div>

        </main>

    </div>

</x-app-layout>