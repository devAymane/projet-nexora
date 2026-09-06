<x-guest-layout>

    <div class="min-h-screen bg-slate-50 flex items-center justify-center px-4 py-10">

        <div class="w-full max-w-5xl grid lg:grid-cols-2 bg-white rounded-3xl shadow-2xl overflow-hidden">

            {{-- LEFT SIDE --}}
            <div class="hidden lg:flex relative bg-indigo-600 p-12 text-white flex-col justify-between overflow-hidden">

                {{-- Decorative circles --}}
                <div class="absolute -top-32 -right-32 w-80 h-80 bg-white/10 rounded-full"></div>
                <div class="absolute bottom-[-120px] left-[-100px] w-72 h-72 bg-purple-500/30 rounded-full"></div>

                <div class="relative z-10">

                    {{-- Logo --}}
                    <a href="{{ url('/') }}" class="flex items-center gap-3">

                        <div class="w-11 h-11 rounded-xl bg-white/15 flex items-center justify-center">
                            <span class="text-white font-bold text-2xl">N</span>
                        </div>

                        <span class="text-2xl font-bold">
                            Nexora
                        </span>

                    </a>


                    <div class="mt-24">

                        <p class="text-indigo-200 text-sm font-semibold uppercase tracking-widest">
                            Smart Freelance Marketplace
                        </p>

                        <h1 class="mt-5 text-5xl font-bold leading-tight">
                            Rejoignez
                            <br>
                            <span class="text-indigo-200">Nexora.</span>
                        </h1>

                        <p class="mt-6 text-indigo-100 text-lg leading-8 max-w-md">
                            Créez votre compte et découvrez une nouvelle
                            façon de travailler, trouver des talents et
                            développer vos projets.
                        </p>


                        {{-- Benefits --}}
                        <div class="mt-10 space-y-5">

                            <div class="flex items-center gap-4">

                                <div class="w-9 h-9 rounded-lg bg-white/15 flex items-center justify-center">
                                    ✓
                                </div>

                                <span class="text-indigo-100">
                                    Trouvez les meilleurs freelances
                                </span>

                            </div>


                            <div class="flex items-center gap-4">

                                <div class="w-9 h-9 rounded-lg bg-white/15 flex items-center justify-center">
                                    ✓
                                </div>

                                <span class="text-indigo-100">
                                    Proposez vos propres services
                                </span>

                            </div>


                            <div class="flex items-center gap-4">

                                <div class="w-9 h-9 rounded-lg bg-white/15 flex items-center justify-center">
                                    ✓
                                </div>

                                <span class="text-indigo-100">
                                    Collaborez simplement avec vos clients
                                </span>

                            </div>

                        </div>

                    </div>

                </div>


                <div class="relative z-10 text-sm text-indigo-200">
                    © {{ date('Y') }} Nexora. Tous droits réservés.
                </div>

            </div>


            {{-- RIGHT SIDE --}}
            <div class="p-8 sm:p-12 lg:p-14">

                <div class="w-full max-w-md mx-auto">


                    {{-- Mobile logo --}}
                    <div class="lg:hidden flex items-center gap-3 mb-8">

                        <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center">

                            <span class="text-white font-bold text-xl">
                                N
                            </span>

                        </div>

                        <span class="text-2xl font-bold text-slate-900">
                            Nexora
                        </span>

                    </div>


                    {{-- Header --}}
                    <div class="mb-8">

                        <h2 class="text-3xl font-bold text-slate-900">
                            Créer un compte
                        </h2>

                        <p class="mt-2 text-slate-500">
                            Rejoignez la communauté Nexora dès maintenant.
                        </p>

                    </div>


                    {{-- REGISTER FORM --}}
                    <form
                        method="POST"
                        action="{{ route('register') }}"
                        class="space-y-5"
                    >

                        @csrf


                        {{-- Nom + Prénom --}}
                        <div class="grid sm:grid-cols-2 gap-4">

                            {{-- Nom --}}
                            <div>

                                <x-input-label
                                    for="nom"
                                    value="Nom"
                                    class="text-sm font-semibold text-slate-700"
                                />

                                <x-text-input
                                    id="nom"
                                    class="block mt-2 w-full rounded-xl border-slate-300
                                           focus:border-indigo-500 focus:ring-indigo-500
                                           py-3"
                                    type="text"
                                    name="nom"
                                    :value="old('nom')"
                                    required
                                    autofocus
                                    autocomplete="family-name"
                                    placeholder="Votre nom"
                                />

                                <x-input-error
                                    :messages="$errors->get('nom')"
                                    class="mt-2"
                                />

                            </div>


                            {{-- Prénom --}}
                            <div>

                                <x-input-label
                                    for="prenom"
                                    value="Prénom"
                                    class="text-sm font-semibold text-slate-700"
                                />

                                <x-text-input
                                    id="prenom"
                                    class="block mt-2 w-full rounded-xl border-slate-300
                                           focus:border-indigo-500 focus:ring-indigo-500
                                           py-3"
                                    type="text"
                                    name="prenom"
                                    :value="old('prenom')"
                                    required
                                    autocomplete="given-name"
                                    placeholder="Votre prénom"
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
                                class="text-sm font-semibold text-slate-700"
                            />

                            <x-text-input
                                id="email"
                                class="block mt-2 w-full rounded-xl border-slate-300
                                       focus:border-indigo-500 focus:ring-indigo-500
                                       py-3"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required
                                autocomplete="username"
                                placeholder="exemple@email.com"
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
                                class="text-sm font-semibold text-slate-700"
                            />

                            <x-text-input
                                id="password"
                                class="block mt-2 w-full rounded-xl border-slate-300
                                       focus:border-indigo-500 focus:ring-indigo-500
                                       py-3"
                                type="password"
                                name="password"
                                required
                                autocomplete="new-password"
                                placeholder="••••••••"
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
                                class="text-sm font-semibold text-slate-700"
                            />

                            <x-text-input
                                id="password_confirmation"
                                class="block mt-2 w-full rounded-xl border-slate-300
                                       focus:border-indigo-500 focus:ring-indigo-500
                                       py-3"
                                type="password"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="••••••••"
                            />

                            <x-input-error
                                :messages="$errors->get('password_confirmation')"
                                class="mt-2"
                            />

                        </div>


                        {{-- Submit --}}
                        <button
                            type="submit"
                            class="w-full py-3.5 px-6 rounded-xl
                                   bg-indigo-600 text-white font-semibold
                                   hover:bg-indigo-700
                                   focus:outline-none focus:ring-2
                                   focus:ring-indigo-500 focus:ring-offset-2
                                   transition duration-200
                                   shadow-lg shadow-indigo-200"
                        >
                            Créer mon compte
                        </button>

                    </form>


                    {{-- Login --}}
                    <div class="mt-8 pt-7 border-t border-slate-100 text-center">

                        <p class="text-sm text-slate-500">
                            Vous avez déjà un compte ?
                        </p>

                        <a
                            href="{{ route('login') }}"
                            class="inline-block mt-2 text-sm font-semibold
                                   text-indigo-600 hover:text-indigo-700 transition"
                        >
                            Se connecter →
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-guest-layout>