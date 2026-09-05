<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-8">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Back --}}
            <div class="mb-6">
                <a
                    href="{{ route('services.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 transition hover:text-indigo-600"
                >
                    ← Retour aux services
                </a>
            </div>


            {{-- Success message --}}
            @if(session('success'))

                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                    {{ session('success') }}
                </div>

            @endif


            {{-- Error message --}}
            @if(session('error'))

                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                    {{ session('error') }}
                </div>

            @endif


            {{-- Main content --}}
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

                {{-- LEFT --}}
                <div class="lg:col-span-2">

                    {{-- Service card --}}
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                        {{-- Image --}}
                        <div class="h-72 bg-slate-100 sm:h-96">

                            @if($service->image)

                                <img
                                    src="{{ asset('storage/' . $service->image) }}"
                                    alt="{{ $service->titre }}"
                                    class="h-full w-full object-cover"
                                >

                            @else

                                <div class="flex h-full items-center justify-center">

                                    <div class="text-center">

                                        <div class="mb-2 text-5xl">
                                            🖼️
                                        </div>

                                        <p class="text-sm font-medium text-slate-400">
                                            Aucune image disponible
                                        </p>

                                    </div>

                                </div>

                            @endif

                        </div>


                        {{-- Content --}}
                        <div class="p-6 sm:p-8">

                            {{-- Category + status --}}
                            <div class="mb-4 flex flex-wrap items-center gap-2">

                                <span
                                    class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-600"
                                >
                                    {{ $service->category->nom }}
                                </span>


                                @if($service->disponibilite)

                                    <span
                                        class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-600"
                                    >
                                        Disponible
                                    </span>

                                @else

                                    <span
                                        class="inline-flex rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-600"
                                    >
                                        Indisponible
                                    </span>

                                @endif

                            </div>


                            {{-- Title --}}
                            <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                                {{ $service->titre }}
                            </h1>


                            {{-- Location --}}
                            <div class="mt-4 flex flex-wrap items-center gap-4 text-sm text-slate-500">

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


                            {{-- Description --}}
                            <div class="mt-8">

                                <h2 class="text-lg font-bold text-slate-900">
                                    Description
                                </h2>

                                <p class="mt-3 whitespace-pre-line text-sm leading-7 text-slate-600">
                                    {{ $service->description }}
                                </p>

                            </div>
                         {{-- Avis clients --}}
<div class="mt-8 rounded-xl bg-white p-6 shadow-sm">

    <div class="flex flex-col gap-4 border-b border-gray-200 pb-5 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-xl font-bold text-gray-900">
                Avis clients
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Découvrez les expériences des clients.
            </p>
        </div>

        {{-- Average --}}
        <div class="flex items-center gap-3">

            @if ($service->avis->count() > 0)

                <div class="text-right">
                    <div class="flex items-center justify-end gap-1">
                        <span class="text-xl font-bold text-gray-900">
                            {{ number_format($service->avis->avg('note'), 1) }}
                        </span>

                        <span class="text-yellow-500">
                            ★
                        </span>
                    </div>

                    <p class="text-xs text-gray-500">
                        {{ $service->avis->count() }}
                        {{ $service->avis->count() > 1 ? 'avis' : 'avis' }}
                    </p>
                </div>

            @else

                <span class="rounded-full bg-gray-100 px-4 py-2 text-sm text-gray-500">
                    Aucun avis

                </span>

            @endif

        </div>

    </div>


    @if ($service->avis->count() > 0)

        <div class="divide-y divide-gray-200">

            @foreach ($service->avis as $avis)

                <div class="py-6 first:pt-6 last:pb-0">

                    <div class="flex items-start justify-between gap-4">

                        <div class="flex items-center gap-3">

                            {{-- Avatar --}}
                            @if ($avis->user->photo)
                                <img src="{{ asset('storage/' . $avis->user->photo) }}"
                                     alt="{{ $avis->user->prenom }}"
                                     class="h-10 w-10 rounded-full object-cover">
                            @else
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 font-semibold text-indigo-700">
                                    {{ strtoupper(substr($avis->user->prenom, 0, 1)) }}
                                </div>
                            @endif

                            <div>
                                <p class="font-semibold text-gray-900">
                                    {{ $avis->user->prenom }}
                                    {{ $avis->user->nom }}
                                </p>

                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($avis->date)->format('d/m/Y') }}
                                </p>
                            </div>

                        </div>

                        {{-- Stars --}}
                        <div class="flex items-center gap-1 text-lg text-yellow-500">
                            @for ($i = 1; $i <= 5; $i++)

                                @if ($i <= $avis->note)
                                    <span>★</span>
                                @else
                                    <span class="text-gray-300">★</span>
                                @endif

                            @endfor
                        </div>

                    </div>

                    {{-- Comment --}}
                    <p class="mt-4 text-sm leading-6 text-gray-600">
                        {{ $avis->commentaire }}
                    </p>

                </div>

            @endforeach

        </div>

    @else

        <div class="py-10 text-center">

            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gray-100">
                <span class="text-2xl">⭐</span>
            </div>

            <h3 class="mt-4 font-semibold text-gray-900">
                Aucun avis pour le moment
            </h3>

            <p class="mt-1 text-sm text-gray-500">
                Soyez le premier client à donner votre avis.
            </p>

        </div>

    @endif

</div>

                            {{-- Provider --}}
                            <div class="mt-8 border-t border-slate-100 pt-8">

                                <h2 class="text-lg font-bold text-slate-900">
                                    À propos du prestataire
                                </h2>

                                <div class="mt-4 flex items-center gap-4">

                                    @if($service->user->photo)

                                        <img
                                            src="{{ asset('storage/' . $service->user->photo) }}"
                                            alt="{{ $service->user->prenom }} {{ $service->user->nom }}"
                                            class="h-14 w-14 rounded-full object-cover"
                                        >

                                    @else

                                        <div class="flex h-14 w-14 items-center justify-center rounded-full bg-indigo-100 text-lg font-bold text-indigo-600">
                                            {{ strtoupper(substr($service->user->prenom, 0, 1)) }}
                                        </div>

                                    @endif


                                    <div>

                                        <p class="font-semibold text-slate-900">
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

                                    <p class="mt-4 text-sm leading-6 text-slate-500">
                                        {{ $service->user->description }}
                                    </p>

                                @endif

                            </div>


                            {{-- Owner / Admin actions --}}
                            @auth

                                @if(auth()->id() === $service->user_id || auth()->user()->hasRole('admin'))

                                    <div class="mt-8 flex flex-col gap-3 border-t border-slate-100 pt-8 sm:flex-row">

                                        <a
                                            href="{{ route('services.edit', $service) }}"
                                            class="inline-flex flex-1 items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700"
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
                                                class="w-full rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-700"
                                            >
                                                Supprimer
                                            </button>

                                        </form>

                                    </div>

                                @endif

                            @endauth

                        </div>

                    </div>

                </div>


                {{-- RIGHT SIDEBAR --}}
                <div class="lg:col-span-1">

                    <div class="sticky top-6 space-y-6">


                        {{-- Price / Booking --}}
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                            <p class="text-sm font-medium text-slate-400">
                                Prix du service
                            </p>

                            <p class="mt-1 text-3xl font-bold text-indigo-600">
                                {{ number_format($service->prix, 2, ',', ' ') }}

                                <span class="text-base font-semibold">
                                    DH
                                </span>
                            </p>


                            {{-- Reservation --}}
                            @auth

                                @if(auth()->user()->hasRole('client'))

                                    @if($service->disponibilite)

                                        <a
                                            href="{{ route('reservations.create', ['service_id' => $service->id]) }}"
                                            class="mt-6 flex w-full items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700"
                                        >
                                            📅 Réserver ce service
                                        </a>

                                    @else

                                        <button
                                            type="button"
                                            disabled
                                            class="mt-6 w-full cursor-not-allowed rounded-xl bg-slate-200 px-5 py-3 text-sm font-semibold text-slate-500"
                                        >
                                            Service indisponible
                                        </button>

                                    @endif


                                    {{-- Favorite --}}
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
                                                class="flex w-full items-center justify-center rounded-xl border border-red-200 bg-red-50 px-5 py-3 text-sm font-semibold text-red-600 transition hover:bg-red-100"
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
                                                class="flex w-full items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                                            >
                                                ♡ Ajouter aux favoris
                                            </button>

                                        </form>

                                    @endif


                                    {{-- Contact provider --}}
                                    @if(auth()->id() !== $service->user_id)

                                        <a
                                            href="{{ route('conversations.create', $service->user) }}"
                                            class="mt-3 flex w-full items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                                        >
                                            💬 Contacter le prestataire
                                        </a>

                                    @endif

                                @endif


                                {{-- Provider viewing own service --}}
                                @if(auth()->id() === $service->user_id)

                                    <div class="mt-6 rounded-xl bg-slate-50 p-4">

                                        <p class="text-sm font-medium text-slate-700">
                                            Vous êtes le prestataire de ce service.
                                        </p>

                                        <p class="mt-1 text-xs leading-5 text-slate-500">
                                            Vous pouvez modifier ou supprimer votre service depuis cette page.
                                        </p>

                                    </div>

                                @endif

                            @else

                                {{-- Guest --}}
                                @if($service->disponibilite)

                                    <a
                                        href="{{ route('login') }}"
                                        class="mt-6 flex w-full items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700"
                                    >
                                        Connectez-vous pour réserver
                                    </a>

                                @endif

                            @endauth

                        </div>


                        {{-- Service information --}}
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                            <h2 class="text-lg font-bold text-slate-900">
                                Informations
                            </h2>

                            <div class="mt-5 space-y-4">

                                <div class="flex items-center justify-between">

                                    <span class="text-sm text-slate-500">
                                        Catégorie
                                    </span>

                                    <span class="text-sm font-semibold text-slate-700">
                                        {{ $service->category->nom }}
                                    </span>

                                </div>


                                <div class="flex items-center justify-between">

                                    <span class="text-sm text-slate-500">
                                        Ville
                                    </span>

                                    <span class="text-sm font-semibold text-slate-700">
                                        {{ $service->ville }}
                                    </span>

                                </div>


                                <div class="flex items-center justify-between">

                                    <span class="text-sm text-slate-500">
                                        Disponibilité
                                    </span>

                                    @if($service->disponibilite)

                                        <span class="text-sm font-semibold text-green-600">
                                            Disponible
                                        </span>

                                    @else

                                        <span class="text-sm font-semibold text-red-600">
                                            Indisponible
                                        </span>

                                    @endif

                                </div>


                                <div class="flex items-center justify-between">

                                    <span class="text-sm text-slate-500">
                                        Statut
                                    </span>

                                    <span class="text-sm font-semibold text-slate-700">
                                        {{ ucfirst($service->statut) }}
                                    </span>

                                </div>

                            </div>

                        </div>


                        {{-- Security / trust --}}
                        <div class="rounded-2xl border border-indigo-100 bg-indigo-50 p-6">

                            <h2 class="font-bold text-indigo-900">
                                🛡️ Nexora
                            </h2>

                            <p class="mt-2 text-sm leading-6 text-indigo-700">
                                Réservez un service directement auprès d'un prestataire
                                présent sur la plateforme.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>