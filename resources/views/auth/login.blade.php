<x-guest-layout>
    <div class="min-h-screen bg-slate-50 flex">

        {{-- LEFT SIDE --}}
        <div class="hidden lg:flex lg:w-1/2 bg-indigo-600 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-indigo-700 to-violet-800"></div>

            <div class="relative z-10 flex flex-col justify-center px-16 text-white">
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-11 h-11 rounded-xl bg-white/10 backdrop-blur-sm flex items-center justify-center">
                            <span class="text-2xl font-bold">N</span>
                        </div>

                        <span class="text-2xl font-bold tracking-tight">
                            Nexora
                        </span>
                    </div>

                    <h1 class="text-4xl xl:text-5xl font-bold leading-tight mb-6">
                        Bienvenue sur
                        <span class="text-indigo-200">Nexora</span>
                    </h1>

                    <p class="text-lg text-indigo-100 max-w-lg leading-relaxed">
                        Connectez-vous pour découvrir des services,
                        gérer vos réservations et collaborer avec des
                        prestataires talentueux.
                    </p>
                </div>

                <div class="space-y-4 text-indigo-100">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                            ✓
                        </div>
                        <span>Trouvez les services adaptés à vos besoins</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                            ✓
                        </div>
                        <span>Réservez facilement vos services</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                            ✓
                        </div>
                        <span>Échangez directement avec les prestataires</span>
                    </div>
                </div>
            </div>

            {{-- Decorative elements --}}
            <div class="absolute -bottom-24 -right-24 w-72 h-72 rounded-full bg-violet-500/30"></div>
            <div class="absolute -top-20 -left-20 w-64 h-64 rounded-full bg-indigo-400/20"></div>
        </div>

        {{-- RIGHT SIDE --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12">
            <div class="w-full max-w-md">

                {{-- Logo mobile --}}
                <div class="flex items-center justify-center gap-2 mb-8 lg:hidden">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center">
                        <span class="text-xl font-bold">N</span>
                    </div>

                    <span class="text-2xl font-bold text-slate-900">
                        Nexora
                    </span>
                </div>

                {{-- Header --}}
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-slate-900">
                        Bon retour 👋
                    </h2>

                    <p class="mt-2 text-slate-500">
                        Connectez-vous à votre compte Nexora
                    </p>
                </div>

                {{-- Session Status --}}
                <x-auth-session-status
                    class="mb-4"
                    :status="session('status')"
                />

                {{-- Login Card --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Email --}}
                        <div>
                            <x-input-label
                                for="email"
                                :value="__('Email')"
                                class="text-slate-700 font-medium"
                            />

                            <x-text-input
                                id="email"
                                class="block mt-2 w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"
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
                        <div class="mt-5">
                            <div class="flex items-center justify-between">
                                <x-input-label
                                    for="password"
                                    :value="__('Mot de passe')"
                                    class="text-slate-700 font-medium"
                                />

                                @if (Route::has('password.request'))
                                    <a
                                        href="{{ route('password.request') }}"
                                        class="text-sm text-indigo-600 hover:text-indigo-700 font-medium"
                                    >
                                        Mot de passe oublié ?
                                    </a>
                                @endif
                            </div>

                            <x-text-input
                                id="password"
                                class="block mt-2 w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"
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

                        {{-- Remember Me --}}
                        <div class="mt-5">
                            <label
                                for="remember_me"
                                class="inline-flex items-center cursor-pointer"
                            >
                                <input
                                    id="remember_me"
                                    type="checkbox"
                                    class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    name="remember"
                                >

                                <span class="ms-2 text-sm text-slate-600">
                                    Se souvenir de moi
                                </span>
                            </label>
                        </div>

                        {{-- Submit --}}
                        <div class="mt-7">
                            <button
                                type="submit"
                                class="w-full inline-flex items-center justify-center px-4 py-3 bg-indigo-600 border border-transparent rounded-xl font-semibold text-sm text-white tracking-wide hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition"
                            >
                                Se connecter
                            </button>
                        </div>
                    </form>

                    {{-- Register --}}
                    <div class="mt-7 pt-6 border-t border-slate-100 text-center">
                        <p class="text-sm text-slate-500">
                            Vous n'avez pas encore de compte ?
                            <a
                                href="{{ route('register') }}"
                                class="font-semibold text-indigo-600 hover:text-indigo-700"
                            >
                                Créer un compte
                            </a>
                        </p>
                    </div>

                </div>

                {{-- Footer --}}
                <p class="text-center text-xs text-slate-400 mt-6">
                    © {{ date('Y') }} Nexora. Tous droits réservés.
                </p>

            </div>
        </div>

    </div>
</x-guest-layout>