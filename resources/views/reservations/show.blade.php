<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('reservations.index') }}"
               class="text-gray-500 hover:text-gray-900">
                ←
            </a>

            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Détails de la réservation
                </h2>

                <p class="text-sm text-gray-500">
                    Réservation #{{ $reservation->id }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Success message --}}
            @if (session('success'))
                <div class="rounded-lg bg-green-50 p-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error message --}}
            @if (session('error'))
                <div class="rounded-lg bg-red-50 p-4 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Reservation information --}}
            <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                <div class="border-b border-gray-200 px-6 py-4">
                    <h3 class="font-semibold text-gray-900">
                        Informations de la réservation
                    </h3>
                </div>

                <div class="grid gap-6 p-6 md:grid-cols-2">

                    {{-- Service --}}
                    <div>
                        <p class="text-sm text-gray-500">Service</p>

                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $reservation->service->titre }}
                        </p>
                    </div>

                    {{-- Provider --}}
                    <div>
                        <p class="text-sm text-gray-500">Prestataire</p>

                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $reservation->service->user->prenom }}
                            {{ $reservation->service->user->nom }}
                        </p>
                    </div>

                    {{-- Client --}}
                    <div>
                        <p class="text-sm text-gray-500">Client</p>

                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $reservation->user->prenom }}
                            {{ $reservation->user->nom }}
                        </p>
                    </div>

                    {{-- Date --}}
                    <div>
                        <p class="text-sm text-gray-500">Date</p>

                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $reservation->date->format('d/m/Y H:i') }}
                        </p>
                    </div>

                    {{-- Price --}}
                    <div>
                        <p class="text-sm text-gray-500">Prix</p>

                        <p class="mt-1 font-semibold text-gray-900">
                            {{ number_format($reservation->service->prix, 2, ',', ' ') }} DH
                        </p>
                    </div>

                    {{-- Status --}}
                    <div>
                        <p class="text-sm text-gray-500">Statut</p>

                        <span class="mt-1 inline-flex rounded-full px-3 py-1 text-sm font-medium
                            @switch($reservation->statut)
                                @case('en_attente')
                                    bg-yellow-100 text-yellow-800
                                    @break

                                @case('acceptee')
                                    bg-blue-100 text-blue-800
                                    @break

                                @case('refusee')
                                    bg-red-100 text-red-800
                                    @break

                                @case('terminee')
                                    bg-green-100 text-green-800
                                    @break

                                @case('annulee')
                                    bg-gray-100 text-gray-800
                                    @break

                                @default
                                    bg-gray-100 text-gray-800
                            @endswitch
                        ">
                            {{ ucfirst(str_replace('_', ' ', $reservation->statut)) }}
                        </span>
                    </div>

                </div>
            </div>

            {{-- Client message --}}
            @if ($reservation->message)
                <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h3 class="font-semibold text-gray-900">
                            Message du client
                        </h3>
                    </div>

                    <div class="p-6">
                        <p class="whitespace-pre-wrap text-sm leading-6 text-gray-700">
                            {{ $reservation->message }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- Actions --}}
            <div class="flex flex-wrap gap-3">

                {{-- Client can cancel pending reservation --}}
                @if (auth()->id() === $reservation->user_id && $reservation->statut === 'en_attente')
                    <form method="POST"
                          action="{{ route('reservations.cancel', $reservation) }}">
                        @csrf
                        @method('PATCH')

                        <button type="submit"
                                class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">
                            Annuler la réservation
                        </button>
                    </form>
                @endif

                {{-- Provider actions --}}
                @if (
                    auth()->id() === $reservation->service->user_id
                    && $reservation->statut === 'en_attente'
                )
                    <form method="POST"
                          action="{{ route('reservations.accept', $reservation) }}">
                        @csrf
                        @method('PATCH')

                        <button type="submit"
                                class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700">
                            Accepter
                        </button>
                    </form>

                    <form method="POST"
                          action="{{ route('reservations.refuse', $reservation) }}">
                        @csrf
                        @method('PATCH')

                        <button type="submit"
                                class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">
                            Refuser
                        </button>
                    </form>
                @endif

                {{-- Provider can complete accepted reservation --}}
                @if (
                    auth()->id() === $reservation->service->user_id
                    && $reservation->statut === 'acceptee'
                )
                    <form method="POST"
                          action="{{ route('reservations.complete', $reservation) }}">
                        @csrf
                        @method('PATCH')

                        <button type="submit"
                                class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                            Marquer comme terminée
                        </button>
                    </form>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>