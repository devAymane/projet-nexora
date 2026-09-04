<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    Détails de l'utilisateur
                </h2>

                <p class="text-sm text-slate-500">
                    Informations du compte utilisateur.
                </p>
            </div>

            <div class="flex gap-2">
                <a
                    href="{{ route('users.index') }}"
                    class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    Retour
                </a>

                <a
                    href="{{ route('users.edit', $user) }}"
                    class="rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                >
                    Modifier
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl space-y-6 px-4 sm:px-6 lg:px-8">

            {{-- Profil --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="bg-indigo-600 px-6 py-8">
                    <div class="flex flex-col items-center gap-4 sm:flex-row">

                        <div class="flex h-20 w-20 items-center justify-center rounded-full bg-white text-2xl font-bold text-indigo-600 shadow">
                            {{ strtoupper(substr($user->prenom, 0, 1) . substr($user->nom, 0, 1)) }}
                        </div>

                        <div class="text-center sm:text-left">
                            <h3 class="text-2xl font-bold text-white">
                                {{ $user->prenom }} {{ $user->nom }}
                            </h3>

                            <p class="mt-1 text-sm text-indigo-100">
                                {{ $user->email }}
                            </p>
                        </div>

                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            ID utilisateur
                        </p>

                        <p class="mt-1 font-medium text-slate-800">
                            #{{ $user->id }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Rôle
                        </p>

                        <div class="mt-2 flex flex-wrap gap-2">
                            @forelse ($user->roles as $role)

                                @php
                                    $roleClasses = match ($role->name) {
                                        'admin' => 'bg-red-100 text-red-700',
                                        'provider' => 'bg-indigo-100 text-indigo-700',
                                        'client' => 'bg-emerald-100 text-emerald-700',
                                        default => 'bg-slate-100 text-slate-700',
                                    };
                                @endphp

                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $roleClasses }}">
                                    {{ ucfirst($role->name) }}
                                </span>

                            @empty
                                <span class="text-sm text-slate-400">
                                    Aucun rôle
                                </span>
                            @endforelse
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Téléphone
                        </p>

                        <p class="mt-1 font-medium text-slate-800">
                            {{ $user->telephone ?: 'Non renseigné' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Localisation
                        </p>

                        <p class="mt-1 font-medium text-slate-800">
                            {{ $user->ville ?: 'Ville non renseignée' }}
                            @if ($user->pays)
                                , {{ $user->pays }}
                            @endif
                        </p>
                    </div>

                    <div class="sm:col-span-2">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Description
                        </p>

                        <p class="mt-2 leading-relaxed text-slate-600">
                            {{ $user->description ?: 'Aucune description.' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Inscrit le
                        </p>

                        <p class="mt-1 font-medium text-slate-800">
                            {{ $user->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Dernière modification
                        </p>

                        <p class="mt-1 font-medium text-slate-800">
                            {{ $user->updated_at->format('d/m/Y H:i') }}
                        </p>
                    </div>

                </div>
            </div>

            {{-- Services --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-6 py-5">
                    <h3 class="text-lg font-bold text-slate-800">
                        Services
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Services publiés par cet utilisateur.
                    </p>
                </div>

                <div class="p-6">
                    @forelse ($user->services as $service)

                        <div class="flex flex-col gap-3 border-b border-slate-100 py-4 last:border-0 sm:flex-row sm:items-center sm:justify-between">

                            <div>
                                <p class="font-semibold text-slate-800">
                                    {{ $service->titre }}
                                </p>

                                <p class="text-sm text-slate-500">
                                    {{ number_format($service->prix, 2, ',', ' ') }} DH
                                </p>
                            </div>

                            <a
                                href="{{ route('services.show', $service) }}"
                                class="text-sm font-semibold text-indigo-600 hover:text-indigo-700"
                            >
                                Voir le service →
                            </a>

                        </div>

                    @empty

                        <p class="text-sm text-slate-500">
                            Aucun service.
                        </p>

                    @endforelse
                </div>
            </div>

            {{-- Réservations --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-6 py-5">
                    <h3 class="text-lg font-bold text-slate-800">
                        Réservations
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Réservations associées à cet utilisateur.
                    </p>
                </div>

                <div class="p-6">
                    @forelse ($user->reservations as $reservation)

                        <div class="flex flex-col gap-3 border-b border-slate-100 py-4 last:border-0 sm:flex-row sm:items-center sm:justify-between">

                            <div>
                                <p class="font-semibold text-slate-800">
                                    {{ $reservation->service->titre ?? 'Service supprimé' }}
                                </p>

                                <p class="text-sm text-slate-500">
                                    {{ $reservation->date->format('d/m/Y H:i') }}
                                </p>
                            </div>

                            <span class="inline-flex w-fit rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                {{ ucfirst(str_replace('_', ' ', $reservation->statut)) }}
                            </span>

                        </div>

                    @empty

                        <p class="text-sm text-slate-500">
                            Aucune réservation.
                        </p>

                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>