<x-guest-layout>
    <div class="min-h-screen bg-slate-50 flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-5xl grid lg:grid-cols-2 bg-white rounded-2xl shadow-xl overflow-hidden">

            {{-- Left side --}}
            <div class="hidden lg:flex relative bg-indigo-600 p-12 text-white flex-col justify-between">
                <div>
                    <a href="{{ url('/') }}" class="text-3xl font-bold tracking-tight">
                        Nexora
                    </a>

                    <div class="mt-20">
                        <p class="text-indigo-200 text-sm font-medium uppercase tracking-wider">
                            Smart Freelance Marketplace
                        </p>

                        <h1 class="mt-4 text-4xl font-bold leading-tight">
                            Trouvez les bons talents.
                            <br>
                            Développez vos projets.
                        </h1>

                        <p class="mt-6 text-indigo-100 leading-7 max-w-md">
                            Rejoignez Nexora et découvrez une nouvelle façon
                            de trouver ou proposer des services professionnels.
                        </p>
                    </div>
                </div>

                <div class="text-sm text-indigo-200">
                    © {{ date('Y') }} Nexora. Tous droits réservés.
                </div>
            </div>

            {{-- Right side --}}
            <div class="p-8 sm:p-10 lg:p-12">

                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-slate-900">
                        Créer un compte
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">
                        Rejoignez la communauté Nexora dès maintenant.
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    {{-- Nom + Prénom --}}
                    <div class="grid sm:grid-cols-2 gap-4">

                        <div>
                            <x-input-label
                                for="nom"
                                value="Nom"
                                class="text-sm font-medium text-slate-700"
                            />

                            <x-text-input
                                id="nom"
                                class="block mt-2 w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"
                                type="text"
                                name="nom"
                                :value="old('nom')"
                                required
                                autofocus
                                autocomplete="family-name"
                            />

                            <x-input-error
                                :messages="$errors->get('nom')"
                                class="mt-2"
                            />
                        </div>

                        <div>
                            <x-input-label
                                for="prenom"
                                value="Prénom"
                                class="text-sm font-medium text-slate-700"
                            />

                            <x-text-input
                                id="prenom"
                                class="block mt-2 w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"
                                type="text"
                                name="prenom"
                                :value="old('prenom')"
                                required
                                autocomplete="given-name"
                            />

                            <x-input-error
                                :messages="$errors->get('prenom')"
                                class="mt-2"
                            />
                        </div>

                    </div>

                    {{-- Email --}}
                    <div>
                        <x-input-label
                            for="email"
                            value="Adresse email"
                            class="text-sm font-medium text-slate-700"
                        />

                        <x-text-input
                            id="email"
                            class="block mt-2 w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autocomplete="username"
                        />

                        <x-input-error
                            :messages="$errors->get('email')"
                            class="mt-2"
                        />
                    </div>

                    {{-- Password --}}
                    <div>
                        <x-input-label
                            for="password"
                            value="Mot de passe"
                            class="text-sm font-medium text-slate-700"
                        />

                        <x-text-input
                            id="password"
                            class="block mt-2 w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                        />

                        <x-input-error
                            :messages="$errors->get('password')"
                            class="mt-2"
                        />
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <x-input-label
                            for="password_confirmation"
                            value="Confirmer le mot de passe"
                            class="text-sm font-medium text-slate-700"
                        />

                        <x-text-input
                            id="password_confirmation"
                            class="block mt-2 w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                        />

                        <x-input-error
                            :messages="$errors->get('password_confirmation')"
                            class="mt-2"
                        />
                    </div>

                    {{-- Actions --}}
                    <div class="pt-2 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-4">

                        <a
                            href="{{ route('login') }}"
                            class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition"
                        >
                            Déjà inscrit ?
                        </a>

                        <x-primary-button
                            class="justify-center px-6 py-3 rounded-lg bg-indigo-600 hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 transition"
                        >
                            Créer mon compte
                        </x-primary-button>

                    </div>
                </form>

            </div>
        </div>
    </div>
</x-guest-layout>