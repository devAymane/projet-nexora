<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-8">

        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            {{-- =====================================================
                TOP NAVIGATION
            ====================================================== --}}
            <div class="mb-6 flex items-center justify-between">

                <a
                    href="{{ route('reservations.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-indigo-600"
                >
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
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>

                    Retour aux réservations
                </a>

                <span class="text-sm font-medium text-slate-400">
                    #{{ $reservation->id }}
                </span>

            </div>


            {{-- =====================================================
                ALERTS
            ====================================================== --}}

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
                                    stroke-linejoin="round"
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


            {{-- =====================================================
                HEADER
            ====================================================== --}}
            <div class="mb-8 flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

                <div>

                    <p class="text-sm font-semibold text-indigo-600">
                        Réservation #{{ $reservation->id }}
                    </p>

                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                        Détails de la réservation
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                        Retrouvez toutes les informations concernant votre réservation.
                    </p>

                </div>


                {{-- Status --}}
                <div>

                    @switch($reservation->statut)

                        @case('en_attente')

                            <span class="inline-flex items-center gap-2 rounded-full bg-yellow-50 px-4 py-2 text-sm font-semibold text-yellow-700">

                                <span class="h-2 w-2 rounded-full bg-yellow-500"></span>

                                En attente

                            </span>

                            @break


                        @case('acceptee')

                            <span class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700">

                                <span class="h-2 w-2 rounded-full bg-blue-500"></span>

                                Acceptée

                            </span>

                            @break


                        @case('refusee')

                            <span class="inline-flex items-center gap-2 rounded-full bg-red-50 px-4 py-2 text-sm font-semibold text-red-700">

                                <span class="h-2 w-2 rounded-full bg-red-500"></span>

                                Refusée

                            </span>

                            @break


                        @case('terminee')

                            <span class="inline-flex items-center gap-2 rounded-full bg-green-50 px-4 py-2 text-sm font-semibold text-green-700">

                                <span class="h-2 w-2 rounded-full bg-green-500"></span>

                                Terminée

                            </span>

                            @break


                        @case('annulee')

                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-600">

                                <span class="h-2 w-2 rounded-full bg-slate-400"></span>

                                Annulée

                            </span>

                            @break


                        @default

                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-600">

                                {{ ucfirst(str_replace('_', ' ', $reservation->statut)) }}

                            </span>

                    @endswitch

                </div>

            </div>


            {{-- =====================================================
                MAIN GRID
            ====================================================== --}}
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">


                {{-- =================================================
                    LEFT CONTENT
                ================================================== --}}
                <div class="space-y-6 lg:col-span-2">


                    {{-- =============================================
                        SERVICE CARD
                    ============================================== --}}
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                        <div class="border-b border-slate-100 px-6 py-5">

                            <div class="flex items-center justify-between gap-4">

                                <div>

                                    <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">
                                        Service réservé
                                    </p>

                                    <h2 class="mt-1 text-xl font-bold text-slate-900">
                                        {{ $reservation->service?->titre ?? 'Service supprimé' }}
                                    </h2>

                                </div>


                                @if($reservation->service?->category)

                                    <span class="hidden rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 sm:inline-flex">
                                        {{ $reservation->service->category->nom }}
                                    </span>

                                @endif

                            </div>

                        </div>


                        <div class="p-6">

                            <div class="grid gap-5 sm:grid-cols-2">


                                {{-- Price --}}
                                <div class="rounded-xl bg-slate-50 p-4">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">

                                            <svg
                                                class="h-5 w-5"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M12 8c-2.21 0-4 1.12-4 2.5S9.79 13 12 13s4 1.12 4 2.5S14.21 18 12 18m0-13v2m0 10v2m7-7a7 7 0 11-14 0 7 7 0 0114 0z"
                                                />
                                            </svg>

                                        </div>

                                        <div>

                                            <p class="text-xs font-medium text-slate-400">
                                                Prix
                                            </p>

                                            <p class="mt-1 text-lg font-bold text-slate-900">
                                                {{ number_format($reservation->service?->prix ?? 0, 2, ',', ' ') }}
                                                <span class="text-sm font-medium text-slate-500">
                                                    DH
                                                </span>
                                            </p>

                                        </div>

                                    </div>

                                </div>


                                {{-- Date --}}
                                <div class="rounded-xl bg-slate-50 p-4">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">

                                            <svg
                                                class="h-5 w-5"
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

                                        <div>

                                            <p class="text-xs font-medium text-slate-400">
                                                Date
                                            </p>

                                            <p class="mt-1 text-lg font-bold text-slate-900">
                                                {{ $reservation->date?->format('d/m/Y') }}
                                            </p>

                                            <p class="text-xs text-slate-500">
                                                à {{ $reservation->date?->format('H:i') }}
                                            </p>

                                        </div>

                                    </div>

                                </div>


                                {{-- City --}}
                                <div class="rounded-xl bg-slate-50 p-4">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">

                                            <svg
                                                class="h-5 w-5"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M17.657 16.657L13.414 21a2 2 0 01-2.828 0l-4.243-4.343a8 8 0 1111.314 0z"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                                />
                                            </svg>

                                        </div>

                                        <div>

                                            <p class="text-xs font-medium text-slate-400">
                                                Ville
                                            </p>

                                            <p class="mt-1 text-sm font-bold text-slate-900">
                                                {{ $reservation->service?->ville ?? 'Non renseignée' }}
                                            </p>

                                        </div>

                                    </div>

                                </div>


                                {{-- Created --}}
                                <div class="rounded-xl bg-slate-50 p-4">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">

                                            <svg
                                                class="h-5 w-5"
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

                                        <div>

                                            <p class="text-xs font-medium text-slate-400">
                                                Créée le
                                            </p>

                                            <p class="mt-1 text-sm font-bold text-slate-900">
                                                {{ $reservation->created_at?->format('d/m/Y') }}
                                            </p>

                                        </div>

                                    </div>

                                </div>


                            </div>

                        </div>

                    </div>


                    {{-- =============================================
                        PEOPLE
                    ============================================== --}}
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                        <div class="mb-6">

                            <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">
                                Participants
                            </p>

                            <h2 class="mt-1 text-xl font-bold text-slate-900">
                                Client et prestataire
                            </h2>

                        </div>


                        <div class="grid gap-5 md:grid-cols-2">


                            {{-- Client --}}
                            <div class="rounded-xl border border-slate-100 p-5">

                                <div class="flex items-center gap-4">

                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-lg font-bold text-indigo-700">

                                        {{ strtoupper(substr($reservation->user?->prenom ?? 'C', 0, 1)) }}

                                    </div>

                                    <div class="min-w-0">

                                        <p class="text-xs font-medium text-slate-400">
                                            Client
                                        </p>

                                        <p class="truncate font-bold text-slate-900">
                                            {{ $reservation->user?->prenom }}
                                            {{ $reservation->user?->nom }}
                                        </p>

                                        <p class="truncate text-sm text-slate-500">
                                            {{ $reservation->user?->email }}
                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- Provider --}}
                            <div class="rounded-xl border border-slate-100 p-5">

                                <div class="flex items-center gap-4">

                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-slate-100 text-lg font-bold text-slate-700">

                                        {{ strtoupper(substr($reservation->service?->user?->prenom ?? 'P', 0, 1)) }}

                                    </div>

                                    <div class="min-w-0">

                                        <p class="text-xs font-medium text-slate-400">
                                            Prestataire
                                        </p>

                                        <p class="truncate font-bold text-slate-900">
                                            {{ $reservation->service?->user?->prenom }}
                                            {{ $reservation->service?->user?->nom }}
                                        </p>

                                        <p class="truncate text-sm text-slate-500">
                                            {{ $reservation->service?->user?->email }}
                                        </p>

                                    </div>

                                </div>


                                @if(auth()->id() !== $reservation->service?->user_id)

                                    <a
                                        href="{{ route('conversations.create', $reservation->service->user) }}"
                                        class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 transition hover:text-indigo-700"
                                    >

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
                                                d="M8 10h8M8 14h5m6-2a7 7 0 01-7 7H7l-4 2 1.5-4A7 7 0 1119 12z"
                                            />
                                        </svg>

                                        Contacter le prestataire

                                    </a>

                                @endif

                            </div>


                        </div>

                    </div>


                    {{-- =============================================
                        CLIENT MESSAGE
                    ============================================== --}}
                    @if($reservation->message)

                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                            <div class="border-b border-slate-100 px-6 py-5">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">

                                        <svg
                                            class="h-5 w-5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.8"
                                                d="M8 10h8M8 14h5m6-2a7 7 0 01-7 7H7l-4 2 1.5-4A7 7 0 0119 12z"
                                            />
                                        </svg>

                                    </div>

                                    <div>

                                        <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">
                                            Message
                                        </p>

                                        <h2 class="font-bold text-slate-900">
                                            Message du client
                                        </h2>

                                    </div>

                                </div>

                            </div>


                            <div class="p-6">

                                <div class="rounded-xl bg-slate-50 p-5">

                                    <p class="whitespace-pre-wrap text-sm leading-7 text-slate-700">
                                        {{ $reservation->message }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    @endif


                    {{-- =============================================
                        REVIEW
                    ============================================== --}}
                    @if($reservation->statut === 'terminee' && $reservation->avis)

                        <div class="rounded-2xl border border-green-200 bg-green-50 p-6">

                            <div class="flex items-start gap-4">

                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-green-100 text-green-600">

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
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.783.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.363-1.118L4.98 8.719c-.783-.57-.38-1.81.588-1.81H9.03a1 1 0 00.951-.69l1.068-3.292z"
                                        />
                                    </svg>

                                </div>

                                <div>

                                    <p class="font-bold text-green-800">
                                        Avis déjà publié
                                    </p>

                                    <div class="mt-2 flex items-center gap-1">

                                        @for($i = 1; $i <= 5; $i++)

                                            <span class="{{ $i <= $reservation->avis->note ? 'text-yellow-500' : 'text-slate-300' }} text-lg">
                                                ★
                                            </span>

                                        @endfor

                                    </div>

                                    @if($reservation->avis->commentaire)

                                        <p class="mt-2 text-sm leading-6 text-green-700">
                                            {{ $reservation->avis->commentaire }}
                                        </p>

                                    @endif

                                </div>

                            </div>

                        </div>

                    @elseif($reservation->statut === 'terminee' && auth()->id() === $reservation->user_id)

                        <div class="rounded-2xl border border-indigo-200 bg-indigo-50 p-6">

                            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                                <div class="flex items-start gap-4">

                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">

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
                                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.783.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.363-1.118L4.98 8.719c-.783-.57-.38-1.81.588-1.81H9.03a1 1 0 00.951-.69l1.068-3.292z"
                                            />
                                        </svg>

                                    </div>

                                    <div>

                                        <p class="font-bold text-slate-900">
                                            Votre réservation est terminée
                                        </p>

                                        <p class="mt-1 text-sm text-slate-600">
                                            Partagez votre expérience avec ce prestataire.
                                        </p>

                                    </div>

                                </div>


                                <a
                                    href="{{ route('avis.create', $reservation) }}"
                                    class="inline-flex shrink-0 items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700"
                                >
                                    Laisser un avis
                                </a>

                            </div>

                        </div>

                    @endif

                </div>


                {{-- =================================================
                    RIGHT SIDEBAR
                ================================================== --}}
                <div>

                    <div class="sticky top-24 space-y-5">


                        {{-- =========================================
                            STATUS CARD
                        ========================================== --}}
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                État de la réservation
                            </p>


                            <div class="mt-5">


                                @switch($reservation->statut)

                                    @case('en_attente')

                                        <div class="rounded-xl bg-yellow-50 p-4">

                                            <p class="font-bold text-yellow-800">
                                                En attente de confirmation
                                            </p>

                                            <p class="mt-1 text-xs leading-5 text-yellow-700">
                                                Le prestataire doit encore accepter ou refuser votre demande.
                                            </p>

                                        </div>

                                        @break


                                    @case('acceptee')

                                        <div class="rounded-xl bg-blue-50 p-4">

                                            <p class="font-bold text-blue-800">
                                                Réservation acceptée
                                            </p>

                                            <p class="mt-1 text-xs leading-5 text-blue-700">
                                                Votre réservation a été confirmée par le prestataire.
                                            </p>

                                        </div>

                                        @break


                                    @case('refusee')

                                        <div class="rounded-xl bg-red-50 p-4">

                                            <p class="font-bold text-red-800">
                                                Réservation refusée
                                            </p>

                                            <p class="mt-1 text-xs leading-5 text-red-700">
                                                Le prestataire a refusé cette réservation.
                                            </p>

                                        </div>

                                        @break


                                    @case('terminee')

                                        <div class="rounded-xl bg-green-50 p-4">

                                            <p class="font-bold text-green-800">
                                                Service terminé
                                            </p>

                                            <p class="mt-1 text-xs leading-5 text-green-700">
                                                Cette réservation a été marquée comme terminée.
                                            </p>

                                        </div>

                                        @break


                                    @case('annulee')

                                        <div class="rounded-xl bg-slate-100 p-4">

                                            <p class="font-bold text-slate-800">
                                                Réservation annulée
                                            </p>

                                            <p class="mt-1 text-xs leading-5 text-slate-600">
                                                Cette réservation n'est plus active.
                                            </p>

                                        </div>

                                        @break

                                @endswitch

                            </div>

                        </div>


                        {{-- =========================================
                            ACTIONS
                        ========================================== --}}
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Actions
                            </p>


                            <div class="mt-5 space-y-3">


                                {{-- Client cancel --}}
                                @if(
                                    auth()->id() === $reservation->user_id
                                    && $reservation->statut === 'en_attente'
                                )

                                    <form
                                        method="POST"
                                        action="{{ route('reservations.cancel', $reservation) }}"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?');"
                                    >

                                        @csrf

                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-red-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-red-700"
                                        >

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
                                                    d="M6 6l12 12M6 18L18 6"
                                                />
                                            </svg>

                                            Annuler la réservation

                                        </button>

                                    </form>

                                @endif


                                {{-- Provider accept/refuse --}}
                                @if(
                                    auth()->id() === $reservation->service?->user_id
                                    && $reservation->statut === 'en_attente'
                                )

                                    <form
                                        method="POST"
                                        action="{{ route('reservations.accept', $reservation) }}"
                                    >

                                        @csrf

                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700"
                                        >

                                            <svg
                                                class="h-4 w-4"
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

                                            Accepter la réservation

                                        </button>

                                    </form>


                                    <form
                                        method="POST"
                                        action="{{ route('reservations.refuse', $reservation) }}"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir refuser cette réservation ?');"
                                    >

                                        @csrf

                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-white px-4 py-3 text-sm font-semibold text-red-600 transition hover:bg-red-50"
                                        >

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
                                                    d="M6 6l12 12M6 18L18 6"
                                                />
                                            </svg>

                                            Refuser la réservation

                                        </button>

                                    </form>

                                @endif


                                {{-- Provider complete --}}
                                @if(
                                    auth()->id() === $reservation->service?->user_id
                                    && $reservation->statut === 'acceptee'
                                )

                                    <form
                                        method="POST"
                                        action="{{ route('reservations.complete', $reservation) }}"
                                        onsubmit="return confirm('Marquer cette réservation comme terminée ?');"
                                    >

                                        @csrf

                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-green-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-green-700"
                                        >

                                            <svg
                                                class="h-4 w-4"
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

                                            Marquer comme terminée

                                        </button>

                                    </form>

                                @endif


                                {{-- Back --}}
                                <a
                                    href="{{ route('reservations.index') }}"
                                    class="flex w-full items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                                >
                                    Retour aux réservations
                                </a>

                            </div>

                        </div>


                        {{-- =========================================
                            SERVICE LINK
                        ========================================== --}}
                        @if($reservation->service)

                            <a
                                href="{{ route('services.show', $reservation->service) }}"
                                class="block rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-200 hover:shadow-md"
                            >

                                <div class="flex items-center justify-between gap-3">

                                    <div>

                                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                            Service
                                        </p>

                                        <p class="mt-1 font-bold text-slate-900">
                                            Voir le service
                                        </p>

                                    </div>

                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">

                                        <svg
                                            class="h-5 w-5"
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

                                    </div>

                                </div>

                            </a>

                        @endif


                        {{-- =========================================
                            TRUST CARD
                        ========================================== --}}
                        <div class="rounded-2xl bg-indigo-600 p-5 text-white shadow-sm">

                            <div class="flex items-start gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/10">

                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4z"
                                        />
                                    </svg>

                                </div>

                                <div>

                                    <p class="font-semibold">
                                        Nexora sécurisé
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-indigo-100">
                                        Vos réservations et vos échanges sont protégés sur la plateforme.
                                    </p>

                                </div>

                            </div>

                        </div>


                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>