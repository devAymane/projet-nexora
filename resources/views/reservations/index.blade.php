<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">
                Mes réservations
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Consultez et gérez vos réservations.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

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

                <div class="border-b border-slate-200 px-6 py-5">
                    <h3 class="text-lg font-bold text-slate-800">
                        Liste des réservations
                    </h3>
                </div>

                @if ($reservations->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Service
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Date
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Statut
                                    </th>

                                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Action
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-200 bg-white">
                                @foreach ($reservations as $reservation)
                                    <tr class="hover:bg-slate-50">

                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-slate-800">
                                                {{ $reservation->service->titre }}
                                            </div>

                                            <div class="mt-1 text-sm text-slate-500">
                                                {{ $reservation->service->ville }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-sm text-slate-600">
                                            {{ $reservation->date->format('d/m/Y à H:i') }}
                                        </td>

                                        <td class="px-6 py-4">
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

                                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClasses[$reservation->statut] ?? 'bg-slate-100 text-slate-600' }}">
                                                {{ $statusLabels[$reservation->statut] ?? $reservation->statut }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 text-right">
                                            <a
                                                href="{{ route('reservations.show', $reservation) }}"
                                                class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700"
                                            >
                                                Voir
                                            </a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="border-t border-slate-200 px-6 py-4">
                        {{ $reservations->links() }}
                    </div>
                @else
                    <div class="px-6 py-12 text-center">
                        <h3 class="text-lg font-semibold text-slate-800">
                            Aucune réservation
                        </h3>

                        <p class="mt-2 text-sm text-slate-500">
                            Vous n'avez encore aucune réservation.
                        </p>

                        <a
                            href="{{ route('reservations.create') }}"
                            class="mt-5 inline-flex items-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                        >
                            Réserver un service
                        </a>
                    </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>