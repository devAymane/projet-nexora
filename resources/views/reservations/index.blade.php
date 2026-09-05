<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-8">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                        Réservations
                    </h1>

                    <p class="mt-2 text-sm text-slate-500">
                        Gérez vos réservations et suivez leur statut.
                    </p>
                </div>

                @if(auth()->user()->hasRole('client'))
                    <a
                        href="{{ route('reservations.create') }}"
                        class="inline-flex w-full items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 sm:w-auto"
                    >
                        + Nouvelle réservation
                    </a>
                @endif

            </div>


            {{-- Success --}}
            @if(session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                    {{ session('success') }}
                </div>
            @endif


            {{-- Error --}}
            @if(session('error'))
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                    {{ session('error') }}
                </div>
            @endif


            {{-- Reservations --}}
            @if($reservations->count())

                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-slate-200">

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


                            <tbody class="divide-y divide-slate-100 bg-white">

                                @foreach($reservations as $reservation)

                                    <tr class="transition hover:bg-slate-50">

                                        {{-- Service --}}
                                        <td class="px-6 py-5">

                                            <div class="font-semibold text-slate-900">
                                                {{ $reservation->service?->titre ?? 'Service supprimé' }}
                                            </div>

                                            <p class="mt-1 text-xs text-slate-400">
                                                Réservation #{{ $reservation->id }}
                                            </p>

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

                                            <p class="text-sm font-medium text-slate-700">
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
                                                    <span class="inline-flex rounded-full bg-yellow-50 px-3 py-1 text-xs font-semibold text-yellow-600">
                                                        En attente
                                                    </span>
                                                    @break

                                                @case('acceptee')
                                                    <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-600">
                                                        Acceptée
                                                    </span>
                                                    @break

                                                @case('refusee')
                                                    <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-600">
                                                        Refusée
                                                    </span>
                                                    @break

                                                @case('terminee')
                                                    <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-600">
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


                                                {{-- Client actions --}}
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


                                                {{-- Provider actions --}}
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


                {{-- Pagination --}}
                @if($reservations->hasPages())

                    <div class="mt-8">
                        {{ $reservations->links() }}
                    </div>

                @endif


            @else

                {{-- Empty state --}}
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center shadow-sm">

                    <div class="mx-auto max-w-md">

                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-indigo-50 text-indigo-600">

                            <svg
                                class="h-7 w-7"
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