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
                            Bienvenue
                            <br>
                            sur <span class="text-indigo-200">Nexora.</span>
                        </h1>

                        <p class="mt-6 text-indigo-100 text-lg leading-8 max-w-md">
                            Connectez-vous pour découvrir des services,
                            gérer vos réservations et collaborer avec des
                            prestataires talentueux.
                        </p>

                        {{-- Benefits --}}
                        <div class="mt-10 space-y-5">

                            <div class="flex items-center gap-4">
                                <div class="w-9 h-9 rounded-lg bg-white/15 flex items-center justify-center">
                                    ✓
                                </div>

                                <span class="text-indigo-100">
                                    Trouvez les services adaptés à vos besoins
                                </span>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="w-9 h-9 rounded-lg bg-white/15 flex items-center justify-center">
                                    ✓
                                </div>

                                <span class="text-indigo-100">
                                    Réservez facilement vos services
                                </span>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="w-9 h-9 rounded-lg bg-white/15 flex items-center justify-center">
                                    ✓
                                </div>

                                <span class="text-indigo-100">
                                    Échangez directement avec les freelances
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
            <div class="p-8 sm:p-12 lg:p-14 flex items-center">

                <div class="w-full max-w-md mx-auto">

                    {{-- Header --}}
                    <div class="mb-8">

                        <div class="lg:hidden flex items-center gap-3 mb-8">
                            <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center">
                                <span class="text-white font-bold text-xl">N</span>
                            </div>

                            <span class="text-2xl font-bold text-slate-900">
                                Nexora
                            </span>
                        </div>

                        <h2 class="text-3xl font-bold text-slate-900">
                            Bon retour 👋
                        </h2>

                        <p class="mt-2 text-slate-500">
                            Connectez-vous à votre compte Nexora
                        </p>

                    </div>


                    {{-- Session status --}}
                    <x-auth-session-status
                        class="mb-4"
                        :status="session('status')"
                    />


                    {{-- LOGIN FORM --}}
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">

                        @csrf

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
                                autofocus
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

                            <div class="flex items-center justify-between">

                                <x-input-label
                                    for="password"
                                    value="Mot de passe"
                                    class="text-sm font-semibold text-slate-700"
                                />

                                @if (Route::has('password.request'))

                                    <a
                                        href="{{ route('password.request') }}"
                                        class="text-sm font-medium text-indigo-600 hover:text-indigo-700 transition"
                                    >
                                        Mot de passe oublié ?
                                    </a>

                                @endif

                            </div>

                            <x-text-input
                                id="password"
                                class="block mt-2 w-full rounded-xl border-slate-300
                                       focus:border-indigo-500 focus:ring-indigo-500
                                       py-3"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••"
                            />

                            <x-input-error
                                :messages="$errors->get('password')"
                                class="mt-2"
                            />

                        </div>


                        {{-- Remember --}}
                        <div class="flex items-center">

                            <label for="remember" class="inline-flex items-center cursor-pointer">

                                <input
                                    id="remember"
                                    type="checkbox"
                                    name="remember"
                                    class="rounded border-slate-300 text-indigo-600
                                           shadow-sm focus:ring-indigo-500"
                                >

                                <span class="ms-2 text-sm text-slate-600">
                                    Se souvenir de moi
                                </span>

                            </label>

                        </div>


                        {{-- Button --}}
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
                            Se connecter
                        </button>

                    </form>


                    {{-- Register --}}
                    <div class="mt-8 pt-7 border-t border-slate-100 text-center">

                        <p class="text-sm text-slate-500">
                            Vous n'avez pas encore de compte ?
                        </p>

                        <a
                            href="{{ route('register') }}"
                            class="inline-block mt-2 text-sm font-semibold
                                   text-indigo-600 hover:text-indigo-700 transition"
                        >
                            Créer un compte →
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-guest-layout>