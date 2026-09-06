<x-app-layout>
    <div class="min-h-screen bg-slate-50">
        <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8">
                <div class="mb-2 flex items-center gap-2 text-sm text-slate-500">
                    <a href="{{ route('dashboard') }}" class="hover:text-indigo-600">
                        Dashboard
                    </a>
                    <span>/</span>
                    <span class="text-slate-700">Mon profil</span>
                </div>

                <h1 class="text-3xl font-bold text-slate-900">
                    Mon profil
                </h1>

                <p class="mt-1 text-slate-500">
                    Gérez vos informations personnelles et les paramètres de votre compte.
                </p>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">

                {{-- Profile card --}}
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

                    <div class="flex flex-col items-center text-center">

                        @if ($user->photo)
                            <img
                                src="{{ asset('storage/' . $user->photo) }}"
                                alt="Photo de profil"
                                class="h-24 w-24 rounded-full object-cover ring-4 ring-indigo-50"
                            >
                        @else
                            <div class="flex h-24 w-24 items-center justify-center rounded-full bg-indigo-100 text-3xl font-bold text-indigo-600 ring-4 ring-indigo-50">
                                {{ strtoupper(substr($user->prenom ?? $user->nom ?? 'U', 0, 1)) }}
                            </div>
                        @endif

                        <h2 class="mt-4 text-xl font-bold text-slate-900">
                            {{ $user->prenom }} {{ $user->nom }}
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            {{ $user->email }}
                        </p>

                        @if ($user->hasRole('admin'))
                            <span class="mt-4 rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-600">
                                Administrateur
                            </span>
                        @elseif ($user->hasRole('provider'))
                            <span class="mt-4 rounded-full bg-purple-50 px-3 py-1 text-xs font-semibold text-purple-600">
                                Prestataire
                            </span>
                        @else
                            <span class="mt-4 rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-600">
                                Client
                            </span>
                        @endif
                    </div>

                    <div class="mt-6 border-t border-slate-100 pt-6">

                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-slate-500">Ville</span>
                            <span class="text-sm font-medium text-slate-900">
                                {{ $user->ville ?? 'Non renseignée' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-slate-500">Pays</span>
                            <span class="text-sm font-medium text-slate-900">
                                {{ $user->pays ?? 'Non renseigné' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-slate-500">Téléphone</span>
                            <span class="text-sm font-medium text-slate-900">
                                {{ $user->telephone ?? 'Non renseigné' }}
                            </span>
                        </div>

                    </div>
                </div>

                {{-- Main --}}
                <div class="space-y-6 lg:col-span-2">

                    {{-- Update profile --}}
                    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 sm:p-8">

                        <div class="mb-6">
                            <h2 class="text-xl font-bold text-slate-900">
                                Informations personnelles
                            </h2>

                            <p class="mt-1 text-sm text-slate-500">
                                Modifiez les informations associées à votre compte.
                            </p>
                        </div>

                        @include('profile.partials.update-profile-information-form')

                    </div>

                    {{-- Password --}}
                    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 sm:p-8">

                        <div class="mb-6">
                            <h2 class="text-xl font-bold text-slate-900">
                                Mot de passe
                            </h2>

                            <p class="mt-1 text-sm text-slate-500">
                                Utilisez un mot de passe long et sécurisé.
                            </p>
                        </div>

                        @include('profile.partials.update-password-form')

                    </div>

                    {{-- Delete account --}}
                    <div class="rounded-2xl border border-red-100 bg-red-50/50 p-6 shadow-sm sm:p-8">

                        <div class="mb-6">
                            <h2 class="text-xl font-bold text-red-700">
                                Supprimer le compte
                            </h2>

                            <p class="mt-1 text-sm text-red-600/80">
                                Cette action est définitive. Toutes vos données personnelles seront supprimées.
                            </p>
                        </div>

                        @include('profile.partials.delete-user-form')

                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>