<x-app-layout>
    <div class="min-h-screen bg-slate-50 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <div class="mb-2 flex items-center gap-2 text-sm font-medium text-indigo-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Gestion
                    </div>

                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                        Réservations
                    </h1>

                    <p class="mt-2 text-sm text-slate-500">
                        Gérez vos réservations et suivez leur évolution.
                    </p>
                </div>

                @if(auth()->user()->hasRole('client'))
                    <a href="{{ route('reservations.create') }}"
                       class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 hover:shadow-md">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4v16m8-8H4"/>
                        </svg>
                        Nouvelle réservation
                    </a>
                @endif
            </div>

            {{-- ALERTS --}}
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            @if($reservations->count())

                {{-- STATS --}}
                <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-500">Total</p>
                                <p class="mt-2 text-3xl font-bold text-slate-900">
                                    {{ $stats['total'] ?? $reservations->total() }}
                                </p>
                            </div>
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-500">En attente</p>
                                <p class="mt-2 text-3xl font-bold text-slate-900">
                                    {{ $stats['pending'] ?? $reservations->getCollection()->where('statut', 'en_attente')->count() }}
                                </p>
                            </div>
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                          d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-500">Acceptées</p>
                                <p class="mt-2 text-3xl font-bold text-slate-900">
                                    {{ $stats['accepted'] ?? $reservations->getCollection()->where('statut', 'acceptee')->count() }}
                                </p>
                            </div>
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                          d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-500">Terminées</p>
                                <p class="mt-2 text-3xl font-bold text-slate-900">
                                    {{ $stats['completed'] ?? $reservations->getCollection()->where('statut', 'terminee')->count() }}
                                </p>
                            </div>
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50 text-green-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                          d="M5 13l4 4L10 20 20 10"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- MAIN CARD --}}
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                    {{-- CARD HEADER --}}
                    <div class="flex flex-col gap-3 border-b border-slate-200 bg-white px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-lg font-bold text-slate-900">
                                Liste des réservations
                            </h2>
                            <p class="mt-1 text-sm text-slate-500">
                                {{ $reservations->total() }}
                                réservation{{ $reservations->total() > 1 ? 's' : '' }}
                            </p>
                        </div>

                        <div class="inline-flex w-fit items-center rounded-lg bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-600">
                            Dernières réservations
                        </div>
                    </div>

                    {{-- DESKTOP --}}
                    <div class="hidden overflow-x-auto md:block">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-slate-200 bg-slate-50">
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

                            <tbody class="divide-y divide-slate-100">
                                @foreach($reservations as $reservation)
                                    <tr class="transition hover:bg-slate-50/80">

                                        {{-- SERVICE --}}
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-50 font-bold text-indigo-600">
                                                    {{ strtoupper(substr($reservation->service?->titre ?? 'S', 0, 1)) }}
                                                </div>

                                                <div class="min-w-0">
                                                    <p class="max-w-[220px] truncate font-semibold text-slate-900">
                                                        {{ $reservation->service?->titre ?? 'Service supprimé' }}
                                                    </p>
                                                    <p class="mt-1 text-xs text-slate-400">
                                                        #{{ $reservation->id }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- CLIENT --}}
                                        <td class="px-6 py-5">
                                            <p class="font-semibold text-slate-900">
                                                {{ $reservation->user?->prenom }}
                                                {{ $reservation->user?->nom }}
                                            </p>
                                            <p class="mt-1 max-w-[170px] truncate text-xs text-slate-400">
                                                {{ $reservation->user?->email }}
                                            </p>
                                        </td>

                                        {{-- PROVIDER --}}
                                        <td class="px-6 py-5">
                                            <p class="font-semibold text-slate-900">
                                                {{ $reservation->service?->user?->prenom }}
                                                {{ $reservation->service?->user?->nom }}
                                            </p>
                                            <p class="mt-1 max-w-[170px] truncate text-xs text-slate-400">
                                                {{ $reservation->service?->user?->email }}
                                            </p>
                                        </td>

                                        {{-- DATE --}}
                                        <td class="whitespace-nowrap px-6 py-5">
                                            <p class="font-semibold text-slate-900">
                                                {{ $reservation->date?->format('d/m/Y') }}
                                            </p>
                                            <p class="mt-1 text-xs text-slate-400">
                                                {{ $reservation->date?->format('H:i') }}
                                            </p>
                                        </td>

                                        {{-- STATUS --}}
                                        <td class="px-6 py-5">
                                            @switch($reservation->statut)
                                                @case('en_attente')
                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-700">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                                        En attente
                                                    </span>
                                                    @break

                                                @case('acceptee')
                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                                        Acceptée
                                                    </span>
                                                    @break

                                                @case('refusee')
                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                                        Refusée
                                                    </span>
                                                    @break

                                                @case('terminee')
                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-3 py-1.5 text-xs font-semibold text-green-700">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                                        Terminée
                                                    </span>
                                                    @break

                                                @case('annulee')
                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                                        Annulée
                                                    </span>
                                                    @break

                                                @default
                                                    <span class="rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">
                                                        {{ $reservation->statut }}
                                                    </span>
                                            @endswitch
                                        </td>

                                        {{-- ACTIONS --}}
                                        <td class="px-6 py-5">
                                            <div class="flex justify-end gap-2">

                                                <a href="{{ route('reservations.show', $reservation) }}"
                                                   class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                                                    Voir
                                                </a>

                                                @if(auth()->user()->hasRole('client')
                                                    && $reservation->user_id === auth()->id()
                                                    && $reservation->statut === 'en_attente')

                                                    <form action="{{ route('reservations.cancel', $reservation) }}" method="POST"
                                                          onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?');">
                                                        @csrf
                                                        @method('PATCH')

                                                        <button type="submit"
                                                                class="rounded-lg bg-red-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-red-700">
                                                            Annuler
                                                        </button>
                                                    </form>
                                                @endif

                                                @if(auth()->user()->hasRole('provider')
                                                    && $reservation->service?->user_id === auth()->id())

                                                    @if($reservation->statut === 'en_attente')
                                                        <form action="{{ route('reservations.accept', $reservation) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button class="rounded-lg bg-indigo-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-indigo-700">
                                                                Accepter
                                                            </button>
                                                        </form>

                                                        <form action="{{ route('reservations.refuse', $reservation) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button class="rounded-lg bg-red-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-red-700">
                                                                Refuser
                                                            </button>
                                                        </form>
                                                    @elseif($reservation->statut === 'acceptee')
                                                        <form action="{{ route('reservations.complete', $reservation) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button class="rounded-lg bg-green-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-green-700">
                                                                Terminer
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif

                                                @if(auth()->user()->hasRole('admin'))

                                                    @if($reservation->statut === 'en_attente')
                                                        <form action="{{ route('reservations.accept', $reservation) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button class="rounded-lg bg-indigo-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-indigo-700">
                                                                Accepter
                                                            </button>
                                                        </form>

                                                        <form action="{{ route('reservations.refuse', $reservation) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button class="rounded-lg bg-red-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-red-700">
                                                                Refuser
                                                            </button>
                                                        </form>
                                                    @elseif($reservation->statut === 'acceptee')
                                                        <form action="{{ route('reservations.complete', $reservation) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button class="rounded-lg bg-green-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-green-700">
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

                    {{-- MOBILE --}}
                    <div class="divide-y divide-slate-100 md:hidden">
                        @foreach($reservations as $reservation)
                            <article class="p-5">

                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex min-w-0 items-center gap-3">
                                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-50 font-bold text-indigo-600">
                                            {{ strtoupper(substr($reservation->service?->titre ?? 'S', 0, 1)) }}
                                        </div>

                                        <div class="min-w-0">
                                            <h3 class="truncate font-semibold text-slate-900">
                                                {{ $reservation->service?->titre ?? 'Service supprimé' }}
                                            </h3>
                                            <p class="mt-1 text-xs text-slate-400">
                                                Réservation #{{ $reservation->id }}
                                            </p>
                                        </div>
                                    </div>

                                    @switch($reservation->statut)
                                        @case('en_attente')
                                            <span class="shrink-0 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">
                                                En attente
                                            </span>
                                            @break
                                        @case('acceptee')
                                            <span class="shrink-0 rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700">
                                                Acceptée
                                            </span>
                                            @break
                                        @case('refusee')
                                            <span class="shrink-0 rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700">
                                                Refusée
                                            </span>
                                            @break
                                        @case('terminee')
                                            <span class="shrink-0 rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                                Terminée
                                            </span>
                                            @break
                                        @case('annulee')
                                            <span class="shrink-0 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                                Annulée
                                            </span>
                                            @break
                                    @endswitch
                                </div>

                                <div class="mt-5 grid grid-cols-2 gap-3">
                                    <div class="rounded-xl bg-slate-50 p-4">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                            Client
                                        </p>
                                        <p class="mt-1 text-sm font-semibold text-slate-700">
                                            {{ $reservation->user?->prenom }}
                                            {{ $reservation->user?->nom }}
                                        </p>
                                    </div>

                                    <div class="rounded-xl bg-slate-50 p-4">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                            Date
                                        </p>
                                        <p class="mt-1 text-sm font-semibold text-slate-700">
                                            {{ $reservation->date?->format('d/m/Y') }}
                                        </p>
                                        <p class="text-xs text-slate-400">
                                            {{ $reservation->date?->format('H:i') }}
                                        </p>
                                    </div>

                                    <div class="col-span-2 rounded-xl bg-slate-50 p-4">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                            Prestataire
                                        </p>
                                        <p class="mt-1 text-sm font-semibold text-slate-700">
                                            {{ $reservation->service?->user?->prenom }}
                                            {{ $reservation->service?->user?->nom }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4 flex flex-col gap-2">
                                    <a href="{{ route('reservations.show', $reservation) }}"
                                       class="inline-flex w-full items-center justify-center rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                                        Voir les détails
                                    </a>

                                    @if(auth()->user()->hasRole('client')
                                        && $reservation->user_id === auth()->id()
                                        && $reservation->statut === 'en_attente')

                                        <form action="{{ route('reservations.cancel', $reservation) }}" method="POST"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?');">
                                            @csrf
                                            @method('PATCH')
                                            <button class="w-full rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-700">
                                                Annuler
                                            </button>
                                        </form>
                                    @endif

                                    @if(auth()->user()->hasRole('provider')
                                        && $reservation->service?->user_id === auth()->id())

                                        @if($reservation->statut === 'en_attente')
                                            <form action="{{ route('reservations.accept', $reservation) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                                                    Accepter
                                                </button>
                                            </form>

                                            <form action="{{ route('reservations.refuse', $reservation) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button class="w-full rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-700">
                                                    Refuser
                                                </button>
                                            </form>
                                        @elseif($reservation->statut === 'acceptee')
                                            <form action="{{ route('reservations.complete', $reservation) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button class="w-full rounded-lg bg-green-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-green-700">
                                                    Terminer
                                                </button>
                                            </form>
                                        @endif
                                    @endif

                                    @if(auth()->user()->hasRole('admin'))

                                        @if($reservation->statut === 'en_attente')
                                            <form action="{{ route('reservations.accept', $reservation) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                                                    Accepter
                                                </button>
                                            </form>

                                            <form action="{{ route('reservations.refuse', $reservation) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button class="w-full rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-700">
                                                    Refuser
                                                </button>
                                            </form>
                                        @elseif($reservation->statut === 'acceptee')
                                            <form action="{{ route('reservations.complete', $reservation) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button class="w-full rounded-lg bg-green-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-green-700">
                                                    Terminer
                                                </button>
                                            </form>
                                        @endif

                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>

                {{-- PAGINATION --}}
                @if($reservations->hasPages())
                    <div class="mt-6">
                        {{ $reservations->links() }}
                    </div>
                @endif

            @else

                {{-- EMPTY --}}
                <div class="rounded-2xl border border-slate-200 bg-white px-6 py-16 text-center shadow-sm">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>

                    <h2 class="mt-5 text-xl font-bold text-slate-900">
                        Aucune réservation
                    </h2>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                        Vous n'avez aucune réservation pour le moment.
                    </p>

                    @if(auth()->user()->hasRole('client'))
                        <a href="{{ route('services.index') }}"
                           class="mt-6 inline-flex items-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">
                            Découvrir les services
                        </a>
                    @endif
                </div>

            @endif

        </div>
    </div>
</x-app-layout>