<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">
                Modifier l'utilisateur
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Modifier les informations du compte de {{ $user->prenom }} {{ $user->nom }}.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

                <form
                    method="POST"
                    action="{{ route('users.update', $user) }}"
                    class="space-y-6"
                >
                    @csrf
                    @method('PUT')

                    {{-- Nom / Prénom --}}
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                        <div>
                            <label for="prenom" class="block text-sm font-semibold text-slate-700">
                                Prénom
                            </label>

                            <input
                                id="prenom"
                                name="prenom"
                                type="text"
                                value="{{ old('prenom', $user->prenom) }}"
                                required
                                class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            @error('prenom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nom" class="block text-sm font-semibold text-slate-700">
                                Nom
                            </label>

                            <input
                                id="nom"
                                name="nom"
                                type="text"
                                value="{{ old('nom', $user->nom) }}"
                                required
                                class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            @error('nom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700">
                            Adresse email
                        </label>

                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email', $user->email) }}"
                            required
                            class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >

                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Téléphone --}}
                    <div>
                        <label for="telephone" class="block text-sm font-semibold text-slate-700">
                            Téléphone
                        </label>

                        <input
                            id="telephone"
                            name="telephone"
                            type="text"
                            value="{{ old('telephone', $user->telephone) }}"
                            class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >

                        @error('telephone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Pays / Ville --}}
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                        <div>
                            <label for="pays" class="block text-sm font-semibold text-slate-700">
                                Pays
                            </label>

                            <input
                                id="pays"
                                name="pays"
                                type="text"
                                value="{{ old('pays', $user->pays) }}"
                                class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            @error('pays')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="ville" class="block text-sm font-semibold text-slate-700">
                                Ville
                            </label>

                            <input
                                id="ville"
                                name="ville"
                                type="text"
                                value="{{ old('ville', $user->ville) }}"
                                class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            @error('ville')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="block text-sm font-semibold text-slate-700">
                            Description
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >{{ old('description', $user->description) }}</textarea>

                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="border-t border-slate-200 pt-6">
                        <h3 class="text-base font-bold text-slate-800">
                            Modifier le mot de passe
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Laissez vide si vous ne souhaitez pas modifier le mot de passe.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                        <div>
                            <label for="password" class="block text-sm font-semibold text-slate-700">
                                Nouveau mot de passe
                            </label>

                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">
                                Confirmer le mot de passe
                            </label>

                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('users.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                        >
                            Annuler
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700"
                        >
                            Enregistrer les modifications
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>