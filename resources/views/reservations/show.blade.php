<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">
                Détails de la réservation
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Consultez les informations de votre réservation.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                {{-- Header --}}
                <div class="border-b border-slate-200 px-6 py-5">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <div>
                            <h3 class="text-xl font-bold text-slate-800">
                                {{ $reservation->service->titre }}
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Réservation #{{ $reservation->id }}
                            </p>
                        </div>

                        @php
                            $statusClasses = [
                                'en_attente' => 'bg-amber-100 text-amber-700',
                                'acceptee' => 'bg-blue-100 text-blue-700',
                                'refusee' => 'bg-red-100 text-red-700',
                                'terminee' => 'bg-emerald-100 text-emerald-700',
                                'annulee' => 'bg-slate-100 text-slate-600',
                            ];

                            $statusLabels = [
                                'en_attente' => 'En attente',
                                'acceptee' => 'Acceptée',
                                'refusee' => 'Refusée',
                                'terminee' => 'Terminée',
                                'annulee' => 'Annulée',
                            ];
                        @endphp

                        <span class="inline-flex w-fit rounded-full px-4 py-2 text-sm font-semibold {{ $statusClasses[$reservation->statut] ?? 'bg-slate-100 text-slate-600' }}">
                            {{ $statusLabels[$reservation->statut] ?? $reservation->statut }}
                        </span>

                    </div>
                </div>

                {{-- Informations --}}
                <div class="grid gap-6 p-6 sm:grid-cols-2">

                    {{-- Service --}}
                    <div class="rounded-xl bg-slate-50 p-5">
                        <h4 class="mb-4 font-bold text-slate-800">
                            Service
                        </h4>

                        <div class="space-y-3 text-sm">
                            <div>
                                <span class="text-slate-500">Titre</span>
                                <p class="font-semibold text-slate-800">
                                    {{ $reservation->service->titre }}
                                </p>
                            </div>

                            <div>
                                <span class="text-slate-500">Catégorie</span>
                                <p class="font-semibold text-slate-800">
                                    {{ $reservation->service->category->nom }}
                                </p>
                            </div>

                            <div>
                                <span class="text-slate-500">Ville</span>
                                <p class="font-semibold text-slate-800">
                                    {{ $reservation->service->ville }}
                                </p>
                            </div>

                            <div>
                                <span class="text-slate-500">Prix</span>
                                <p class="font-semibold text-indigo-600">
                                    {{ number_format($reservation->service->prix, 2, ',', ' ') }} DH
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Réservation --}}
                    <div class="rounded-xl bg-slate-50 p-5">
                        <h4 class="mb-4 font-bold text-slate-800">
                            Réservation
                        </h4>

                        <div class="space-y-3 text-sm">
                            <div>
                                <span class="text-slate-500">Date prévue</span>
                                <p class="font-semibold text-slate-800">
                                    {{ $reservation->date->format('d/m/Y à H:i') }}
                                </p>
                            </div>

                            <div>
                                <span class="text-slate-500">Client</span>
                                <p class="font-semibold text-slate-800">
                                    {{ $reservation->user->prenom }}
                                    {{ $reservation->user->nom }}
                                </p>
                            </div>

                            <div>
                                <span class="text-slate-500">Prestataire</span>
                                <p class="font-semibold text-slate-800">
                                    {{ $reservation->service->user->prenom }}
                                    {{ $reservation->service->user->nom }}
                                </p>
                            </div>

                            <div>
                                <span class="text-slate-500">Créée le</span>
                                <p class="font-semibold text-slate-800">
                                    {{ $reservation->created_at->format('d/m/Y à H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Message --}}
                @if ($reservation->message)
                    <div class="border-t border-slate-200 px-6 py-6">
                        <h4 class="mb-3 font-bold text-slate-800">
                            Message du client
                        </h4>

                        <div class="rounded-xl bg-slate-50 p-4 text-sm leading-6 text-slate-600">
                            {{ $reservation->message }}
                        </div>
                    </div>
                @endif

                {{-- Avis --}}
                @if ($reservation->avis)
                    <div class="border-t border-slate-200 px-6 py-6">
                        <h4 class="mb-3 font-bold text-slate-800">
                            Avis
                        </h4>

                        <div class="rounded-xl bg-slate-50 p-4">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-800">
                                    {{ $reservation->avis->note }}/5
                                </span>

                                <span class="text-sm text-slate-500">
                                    par {{ $reservation->avis->user->prenom ?? $reservation->user->prenom }}
                                </span>
                            </div>

                            @if ($reservation->avis->commentaire)
                                <p class="mt-2 text-sm text-slate-600">
                                    {{ $reservation->avis->commentaire }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Actions --}}
                <div class="flex flex-col gap-3 border-t border-slate-200 px-6 py-5 sm:flex-row sm:justify-between">

                    <a
                        href="{{ route('reservations.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                    >
                        Retour aux réservations
                    </a>

                    @if (auth()->user()->hasRole('client') && $reservation->statut === 'en_attente')
                        <form
                            method="POST"
                            action="{{ route('reservations.cancel', $reservation) }}"
                        >
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="inline-flex w-full items-center justify-center rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700 sm:w-auto"
                                onclick="return confirm('Voulez-vous vraiment annuler cette réservation ?')"
                            >
                                Annuler la réservation
                            </button>
                        </form>
                    @endif

                </div>

            </div>

        </div>
    </div>
</x-app-layout>