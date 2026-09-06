<x-guest-layout>
    <div class="min-h-screen bg-slate-50">

        <div class="grid min-h-screen lg:grid-cols-2">

            {{-- LEFT SIDE --}}
            <div class="relative hidden overflow-hidden bg-indigo-600 lg:flex">

                <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-indigo-700 to-slate-900"></div>

                <div class="relative z-10 flex w-full flex-col justify-between p-12 xl:p-16">

                    {{-- Logo --}}
                    <div>
                        <a href="{{ url('/') }}"
                           class="inline-flex items-center gap-3">

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white text-lg font-black text-indigo-600 shadow-lg">
                                N
                            </div>

                            <span class="text-2xl font-bold text-white">
                                Nexora
                            </span>

                        </a>
                    </div>

                    {{-- Content --}}
                    <div class="max-w-lg">

                        <div class="mb-6 inline-flex items-center rounded-full bg-white/10 px-4 py-2 text-sm font-medium text-indigo-100 ring-1 ring-white/10">
                            🔐 Compte sécurisé
                        </div>

                        <h1 class="text-4xl font-bold leading-tight text-white xl:text-5xl">
                            Créez un nouveau
                            <span class="text-indigo-200">
                                mot de passe.
                            </span>
                        </h1>

                        <p class="mt-6 text-lg leading-8 text-indigo-100">
                            Choisissez un mot de passe sécurisé pour
                            protéger votre compte Nexora et continuer
                            à utiliser la plateforme en toute tranquillité.
                        </p>

                        <div class="mt-8 space-y-4">

                            <div class="flex items-center gap-3 text-sm text-indigo-100">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/10">
                                    ✓
                                </div>
                                Mot de passe sécurisé
                            </div>

                            <div class="flex items-center gap-3 text-sm text-indigo-100">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/10">
                                    ✓
                                </div>
                                Protection de votre compte
                            </div>

                            <div class="flex items-center gap-3 text-sm text-indigo-100">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/10">
                                    ✓
                                </div>
                                Accès sécurisé à Nexora
                            </div>

                        </div>

                    </div>

                    {{-- Footer --}}
                    <p class="text-sm text-indigo-200">
                        © {{ date('Y') }} Nexora. Tous droits réservés.
                    </p>

                </div>
            </div>


            {{-- RIGHT SIDE --}}
            <div class="flex items-center justify-center px-6 py-12 sm:px-10 lg:px-16">

                <div class="w-full max-w-md">

                    {{-- Mobile logo --}}
                    <div class="mb-10 text-center lg:hidden">

                        <a href="{{ url('/') }}"
                           class="inline-flex items-center gap-3">

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-600 text-lg font-black text-white shadow-lg">
                                N
                            </div>

                            <span class="text-2xl font-bold text-slate-900">
                                Nexora
                            </span>

                        </a>

                    </div>


                    {{-- Header --}}
                    <div class="mb-8">

                        <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-2xl">
                            🔑
                        </div>

                        <h2 class="text-3xl font-bold tracking-tight text-slate-900">
                            Nouveau mot de passe
                        </h2>

                        <p class="mt-3 text-sm leading-6 text-slate-500">
                            Définissez un nouveau mot de passe sécurisé
                            pour récupérer l'accès à votre compte.
                        </p>

                    </div>


                    {{-- Errors --}}
                    @if ($errors->any())

                        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3">

                            <div class="flex items-start gap-3">

                                <span class="text-lg text-red-600">
                                    !
                                </span>

                                <div>

                                    <p class="text-sm font-semibold text-red-700">
                                        Une erreur est survenue
                                    </p>

                                    <ul class="mt-2 space-y-1 text-sm text-red-600">

                                        @foreach ($errors->all() as $error)
                                            <li>• {{ $error }}</li>
                                        @endforeach

                                    </ul>

                                </div>

                            </div>

                        </div>

                    @endif


                    {{-- Form --}}
                    <form
                        method="POST"
                        action="{{ route('password.store') }}"
                        class="space-y-5"
                    >

                        @csrf

                        <input
                            type="hidden"
                            name="token"
                            value="{{ $request->route('token') }}"
                        >


                        {{-- Email --}}
                        <div>

                            <label
                                for="email"
                                class="mb-2 block text-sm font-semibold text-slate-700"
                            >
                                Adresse email
                            </label>

                            <div class="relative">

                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    ✉
                                </div>

                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email', $request->email) }}"
                                    required
                                    autofocus
                                    autocomplete="email"
                                    placeholder="exemple@email.com"
                                    class="block w-full rounded-xl border border-slate-200 bg-white py-3.5 pl-11 pr-4 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                >

                            </div>

                            @error('email')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Password --}}
                        <div>

                            <label
                                for="password"
                                class="mb-2 block text-sm font-semibold text-slate-700"
                            >
                                Nouveau mot de passe
                            </label>

                            <div class="relative">

                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    🔒
                                </div>

                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="new-password"
                                    placeholder="••••••••"
                                    class="block w-full rounded-xl border border-slate-200 bg-white py-3.5 pl-11 pr-4 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                >

                            </div>

                            @error('password')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Confirm password --}}
                        <div>

                            <label
                                for="password_confirmation"
                                class="mb-2 block text-sm font-semibold text-slate-700"
                            >
                                Confirmer le mot de passe
                            </label>

                            <div class="relative">

                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    🔒
                                </div>

                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    placeholder="••••••••"
                                    class="block w-full rounded-xl border border-slate-200 bg-white py-3.5 pl-11 pr-4 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                >

                            </div>

                            @error('password_confirmation')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Submit --}}
                        <button
                            type="submit"
                            class="mt-2 flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >

                            <span>
                                Réinitialiser le mot de passe
                            </span>

                            <span>
                                →
                            </span>

                        </button>

                    </form>


                    {{-- Back --}}
                    <div class="mt-8 text-center">

                        <a
                            href="{{ route('login') }}"
                            class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 transition hover:text-indigo-700"
                        >
                            ← Retour à la connexion
                        </a>

                    </div>


                    {{-- Security --}}
                    <div class="mt-8 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">

                        <div class="flex gap-3">

                            <div class="mt-0.5 text-lg">
                                🛡️
                            </div>

                            <div>

                                <p class="text-sm font-semibold text-slate-800">
                                    Conseils de sécurité
                                </p>

                                <p class="mt-1 text-xs leading-5 text-slate-500">
                                    Utilisez un mot de passe unique avec des
                                    lettres, chiffres et caractères spéciaux.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
</x-guest-layout>