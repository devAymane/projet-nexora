<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-8">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- =========================================================
                HEADER
            ========================================================== --}}
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <div class="mb-2 flex items-center gap-2 text-sm text-slate-500">
                        <a
                            href="{{ route('dashboard') }}"
                            class="transition hover:text-indigo-600"
                        >
                            Dashboard
                        </a>

                        <span>/</span>

                        <span class="text-slate-700">
                            Réservations
                        </span>
                    </div>

                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                        Réservations
                    </h1>

                    <p class="mt-2 text-sm text-slate-500">
                        Gérez vos réservations et suivez leur statut.
                    </p>

                </div>


                {{-- Nouvelle réservation --}}
                @if(auth()->user()->hasRole('client'))

                    <a
                        href="{{ route('reservations.create') }}"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 sm:w-auto"
                    >

                        <span class="text-lg leading-none">
                            +
                        </span>

                        Nouvelle réservation

                    </a>

                @endif

            </div>


            {{-- =========================================================
                ALERT SUCCESS
            ========================================================== --}}
            @if(session('success'))

                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">

                    {{ session('success') }}

                </div>

            @endif


            {{-- =========================================================
                ALERT ERROR
            ========================================================== --}}
            @if(session('error'))

                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">

                    {{ session('error') }}

                </div>

            @endif


            {{-- =========================================================
                STATISTICS
            ========================================================== --}}

            @php

                $total = $reservations->total();

                $pending = $reservations
                    ->getCollection()
                    ->where('statut', 'en_attente')
                    ->count();

                $accepted = $reservations
                    ->getCollection()
                    ->where('statut', 'acceptee')
                    ->count();

                $completed = $reservations
                    ->getCollection()
                    ->where('statut', 'terminee')
                    ->count();

            @endphp


            <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">


                {{-- Total --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm font-medium text-slate-500">
                                Total
                            </p>

                            <p class="mt-2 text-3xl font-bold text-slate-900">
                                {{ $total }}
                            </p>

                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">

                            <svg
                                class="h-6 w-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                />
                            </svg>

                        </div>

                    </div>

                </div>


                {{-- Pending --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm font-medium text-slate-500">
                                En attente
                            </p>

                            <p class="mt-2 text-3xl font-bold text-slate-900">
                                {{ $pending }}
                            </p>

                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-yellow-50 text-yellow-600">

                            <svg
                                class="h-6 w-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>

                        </div>

                    </div>

                </div>


                {{-- Accepted --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm font-medium text-slate-500">
                                Acceptées
                            </p>

                            <p class="mt-2 text-3xl font-bold text-slate-900">
                                {{ $accepted }}
                            </p>

                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                            <svg
                                class="h-6 w-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>

                        </div>

                    </div>

                </div>


                {{-- Completed --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm font-medium text-slate-500">
                                Terminées
                            </p>

                            <p class="mt-2 text-3xl font-bold text-slate-900">
                                {{ $completed }}
                            </p>

                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50 text-green-600">

                            <svg
                                class="h-6 w-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M5 13l4 4L10 20 20 10"
                                />
                            </svg>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =========================================================
                RESERVATIONS
            ========================================================== --}}

            @if($reservations->count())


                {{-- =====================================================
                    DESKTOP TABLE
                ====================================================== --}}

                <div class="hidden overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm md:block">

                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-slate-200">

                            {{-- Header --}}
                            <thead class="bg-slate-50">

                                <tr>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Service
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Client
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Prestataire
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Date
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Statut
                                    </th>

                                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Actions
                                    </th>

                                </tr>

                            </thead>


                            {{-- Body --}}
                            <tbody class="divide-y divide-slate-100 bg-white">


                                @foreach($reservations as $reservation)

                                    <tr class="transition hover:bg-slate-50">


                                        {{-- Service --}}
                                        <td class="px-6 py-5">

                                            <div class="max-w-xs">

                                                <p class="font-semibold text-slate-900">
                                                    {{ $reservation->service?->titre ?? 'Service supprimé' }}
                                                </p>

                                                <p class="mt-1 text-xs text-slate-400">
                                                    Réservation #{{ $reservation->id }}
                                                </p>

                                            </div>

                                        </td>


                                        {{-- Client --}}
                                        <td class="whitespace-nowrap px-6 py-5">

                                            <p class="text-sm font-medium text-slate-700">
                                                {{ $reservation->user?->prenom }}
                                                {{ $reservation->user?->nom }}
                                            </p>

                                            <p class="text-xs text-slate-400">
                                                {{ $reservation->user?->email }}
                                            </p>

                                        </td>


                                        {{-- Provider --}}
                                        <td class="whitespace-nowrap px-6 py-5">

                                            <p class="text-sm font-medium text-slate-700">
                                                {{ $reservation->service?->user?->prenom }}
                                                {{ $reservation->service?->user?->nom }}
                                            </p>

                                            <p class="text-xs text-slate-400">
                                                {{ $reservation->service?->user?->email }}
                                            </p>

                                        </td>


                                        {{-- Date --}}
                                        <td class="whitespace-nowrap px-6 py-5">

                                            <p class="text-sm font-semibold text-slate-700">
                                                {{ $reservation->date?->format('d/m/Y') }}
                                            </p>

                                            <p class="text-xs text-slate-400">
                                                {{ $reservation->date?->format('H:i') }}
                                            </p>

                                        </td>


                                        {{-- Status --}}
                                        <td class="whitespace-nowrap px-6 py-5">

                                            @switch($reservation->statut)

                                                @case('en_attente')

                                                    <span class="inline-flex rounded-full bg-yellow-50 px-3 py-1 text-xs font-semibold text-yellow-700">
                                                        En attente
                                                    </span>

                                                    @break


                                                @case('acceptee')

                                                    <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                                        Acceptée
                                                    </span>

                                                    @break


                                                @case('refusee')

                                                    <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                                        Refusée
                                                    </span>

                                                    @break


                                                @case('terminee')

                                                    <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                                        Terminée
                                                    </span>

                                                    @break


                                                @case('annulee')

                                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                                        Annulée
                                                    </span>

                                                    @break


                                                @default

                                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                                        {{ $reservation->statut }}
                                                    </span>

                                            @endswitch

                                        </td>


                                        {{-- Actions --}}
                                        <td class="whitespace-nowrap px-6 py-5">

                                            <div class="flex justify-end gap-2">


                                                {{-- Voir --}}
                                                <a
                                                    href="{{ route('reservations.show', $reservation) }}"
                                                    class="rounded-lg bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200"
                                                >
                                                    Voir
                                                </a>


                                                {{-- =====================
                                                    CLIENT ACTIONS
                                                ====================== --}}

                                                @if(
                                                    auth()->user()->hasRole('client')
                                                    && $reservation->user_id === auth()->id()
                                                    && in_array($reservation->statut, ['en_attente', 'acceptee'])
                                                )

                                                    <form
                                                        action="{{ route('reservations.cancel', $reservation) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?');"
                                                    >

                                                        @csrf

                                                        @method('PATCH')

                                                        <button
                                                            type="submit"
                                                            class="rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white transition hover:bg-red-700"
                                                        >
                                                            Annuler
                                                        </button>

                                                    </form>

                                                @endif


                                                {{-- =====================
                                                    PROVIDER ACTIONS
                                                ====================== --}}

                                                @if(
                                                    auth()->user()->hasRole('provider')
                                                    && $reservation->service?->user_id === auth()->id()
                                                )


                                                    {{-- Accept / Refuse --}}
                                                    @if($reservation->statut === 'en_attente')


                                                        <form
                                                            action="{{ route('reservations.accept', $reservation) }}"
                                                            method="POST"
                                                        >

                                                            @csrf

                                                            @method('PATCH')

                                                            <button
                                                                type="submit"
                                                                class="rounded-lg bg-indigo-600 px-3 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700"
                                                            >
                                                                Accepter
                                                            </button>

                                                        </form>


                                                        <form
                                                            action="{{ route('reservations.refuse', $reservation) }}"
                                                            method="POST"
                                                        >

                                                            @csrf

                                                            @method('PATCH')

                                                            <button
                                                                type="submit"
                                                                class="rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white transition hover:bg-red-700"
                                                            >
                                                                Refuser
                                                            </button>

                                                        </form>


                                                    {{-- Complete --}}
                                                    @elseif($reservation->statut === 'acceptee')


                                                        <form
                                                            action="{{ route('reservations.complete', $reservation) }}"
                                                            method="POST"
                                                        >

                                                            @csrf

                                                            @method('PATCH')

                                                            <button
                                                                type="submit"
                                                                class="rounded-lg bg-green-600 px-3 py-2 text-sm font-semibold text-white transition hover:bg-green-700"
                                                            >
                                                                Terminer
                                                            </button>

                                                        </form>


                                                    @endif

                                                @endif


                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>


                {{-- =====================================================
                    MOBILE CARDS
                ====================================================== --}}

                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm md:hidden">

                    <div class="divide-y divide-slate-100">


                        @foreach($reservations as $reservation)

                            <div class="p-5">


                                {{-- Card Header --}}
                                <div class="flex items-start justify-between gap-4">

                                    <div class="min-w-0">

                                        <p class="truncate font-semibold text-slate-900">
                                            {{ $reservation->service?->titre ?? 'Service supprimé' }}
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            Réservation #{{ $reservation->id }}
                                        </p>

                                    </div>


                                    {{-- Status --}}
                                    <div class="shrink-0">

                                        @switch($reservation->statut)

                                            @case('en_attente')

                                                <span class="inline-flex rounded-full bg-yellow-50 px-3 py-1 text-xs font-semibold text-yellow-700">
                                                    En attente
                                                </span>

                                                @break


                                            @case('acceptee')

                                                <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                                    Acceptée
                                                </span>

                                                @break


                                            @case('refusee')

                                                <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                                    Refusée
                                                </span>

                                                @break


                                            @case('terminee')

                                                <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                                    Terminée
                                                </span>

                                                @break


                                            @case('annulee')

                                                <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                                    Annulée
                                                </span>

                                                @break


                                            @default

                                                <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                                    {{ $reservation->statut }}
                                                </span>

                                        @endswitch

                                    </div>

                                </div>


                                {{-- Informations --}}
                                <div class="mt-5 grid grid-cols-2 gap-4">


                                    {{-- Date --}}
                                    <div>

                                        <p class="text-xs font-medium text-slate-400">
                                            Date
                                        </p>

                                        <p class="mt-1 text-sm font-semibold text-slate-700">
                                            {{ $reservation->date?->format('d/m/Y') }}
                                        </p>

                                        <p class="text-xs text-slate-400">
                                            {{ $reservation->date?->format('H:i') }}
                                        </p>

                                    </div>


                                    {{-- Provider --}}
                                    <div>

                                        <p class="text-xs font-medium text-slate-400">
                                            Prestataire
                                        </p>

                                        <p class="mt-1 text-sm font-semibold text-slate-700">
                                            {{ $reservation->service?->user?->prenom }}
                                            {{ $reservation->service?->user?->nom }}
                                        </p>

                                    </div>


                                </div>


                                {{-- Actions --}}
                                <div class="mt-5 flex flex-wrap gap-2">


                                    {{-- Voir --}}
                                    <a
                                        href="{{ route('reservations.show', $reservation) }}"
                                        class="rounded-lg bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200"
                                    >
                                        Voir
                                    </a>


                                    {{-- Client --}}
                                    @if(
                                        auth()->user()->hasRole('client')
                                        && $reservation->user_id === auth()->id()
                                        && in_array($reservation->statut, ['en_attente', 'acceptee'])
                                    )

                                        <form
                                            action="{{ route('reservations.cancel', $reservation) }}"
                                            method="POST"
                                            onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?');"
                                        >

                                            @csrf

                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-700"
                                            >
                                                Annuler
                                            </button>

                                        </form>

                                    @endif


                                    {{-- Provider --}}
                                    @if(
                                        auth()->user()->hasRole('provider')
                                        && $reservation->service?->user_id === auth()->id()
                                    )


                                        @if($reservation->statut === 'en_attente')


                                            <form
                                                action="{{ route('reservations.accept', $reservation) }}"
                                                method="POST"
                                            >

                                                @csrf

                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700"
                                                >
                                                    Accepter
                                                </button>

                                            </form>


                                            <form
                                                action="{{ route('reservations.refuse', $reservation) }}"
                                                method="POST"
                                            >

                                                @csrf

                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-700"
                                                >
                                                    Refuser
                                                </button>

                                            </form>


                                        @elseif($reservation->statut === 'acceptee')


                                            <form
                                                action="{{ route('reservations.complete', $reservation) }}"
                                                method="POST"
                                            >

                                                @csrf

                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-green-700"
                                                >
                                                    Terminer
                                                </button>

                                            </form>


                                        @endif


                                    @endif


                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>


                {{-- =====================================================
                    PAGINATION
                ====================================================== --}}

                @if($reservations->hasPages())

                    <div class="mt-8">
                        {{ $reservations->links() }}
                    </div>

                @endif


            @else


                {{-- =====================================================
                    EMPTY STATE
                ====================================================== --}}

                <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center shadow-sm">

                    <div class="mx-auto max-w-md">


                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">

                            <svg
                                class="h-8 w-8"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                />
                            </svg>

                        </div>


                        <h2 class="mt-5 text-xl font-bold text-slate-900">
                            Aucune réservation
                        </h2>


                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Vous n'avez aucune réservation pour le moment.
                        </p>


                        @if(auth()->user()->hasRole('client'))

                            <a
                                href="{{ route('services.index') }}"
                                class="mt-6 inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700"
                            >
                                Découvrir les services
                            </a>

                        @endif


                    </div>

                </div>


            @endif

        </div>

    </div>

</x-app-layout>