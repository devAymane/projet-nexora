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
                            ✉️ Vérification du compte
                        </div>

                        <h1 class="text-4xl font-bold leading-tight text-white xl:text-5xl">
                            Une dernière étape
                            <span class="text-indigo-200">
                                avant de commencer.
                            </span>
                        </h1>

                        <p class="mt-6 text-lg leading-8 text-indigo-100">
                            Vérifiez votre adresse email afin de sécuriser
                            votre compte et profiter pleinement de Nexora.
                        </p>

                        <div class="mt-8 space-y-4">

                            <div class="flex items-center gap-3 text-sm text-indigo-100">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/10">
                                    ✓
                                </div>
                                Sécurisez votre compte
                            </div>

                            <div class="flex items-center gap-3 text-sm text-indigo-100">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/10">
                                    ✓
                                </div>
                                Protégez vos informations
                            </div>

                            <div class="flex items-center gap-3 text-sm text-indigo-100">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/10">
                                    ✓
                                </div>
                                Accédez à toutes les fonctionnalités
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


                    {{-- Icon --}}
                    <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-50 text-3xl">
                        ✉️
                    </div>


                    {{-- Header --}}
                    <div class="mb-8">

                        <h2 class="text-3xl font-bold tracking-tight text-slate-900">
                            Vérifiez votre email
                        </h2>

                        <p class="mt-3 text-sm leading-6 text-slate-500">
                            Merci de vous être inscrit sur Nexora.
                            Avant de continuer, veuillez vérifier votre
                            adresse email en cliquant sur le lien que nous
                            venons de vous envoyer.
                        </p>

                    </div>


                    {{-- Success message --}}
                    @if (session('status') === 'verification-link-sent')

                        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-4">

                            <div class="flex items-start gap-3">

                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-green-100 text-green-600">
                                    ✓
                                </div>

                                <div>

                                    <p class="text-sm font-semibold text-green-700">
                                        Email envoyé !
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-green-600">
                                        Un nouveau lien de vérification vient
                                        d'être envoyé à votre adresse email.
                                    </p>

                                </div>

                            </div>

                        </div>

                    @endif


                    {{-- Main card --}}
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                        <div class="flex items-start gap-4">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-xl">
                                📩
                            </div>

                            <div>

                                <h3 class="font-semibold text-slate-900">
                                    Consultez votre boîte mail
                                </h3>

                                <p class="mt-1 text-sm leading-6 text-slate-500">
                                    Vérifiez également votre dossier
                                    <span class="font-medium text-slate-700">
                                        Spam / Courrier indésirable
                                    </span>
                                    si vous ne trouvez pas notre email.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Resend --}}
                    <form
                        method="POST"
                        action="{{ route('verification.send') }}"
                        class="mt-6"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            <span>
                                Renvoyer l'email de vérification
                            </span>

                            <span>
                                →
                            </span>
                        </button>
                    </form>


                    {{-- Actions --}}
                    <div class="mt-6 flex flex-col items-center gap-4 text-center sm:flex-row sm:justify-between">

                        <a
                            href="{{ route('profile.edit') }}"
                            class="text-sm font-semibold text-slate-600 transition hover:text-indigo-600"
                        >
                            Modifier mon email
                        </a>

                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="text-sm font-semibold text-red-500 transition hover:text-red-600"
                            >
                                Se déconnecter
                            </button>
                        </form>

                    </div>


                    {{-- Security note --}}
                    <div class="mt-8 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">

                        <div class="flex gap-3">

                            <div class="mt-0.5 text-lg">
                                🛡️
                            </div>

                            <div>

                                <p class="text-sm font-semibold text-slate-800">
                                    Pourquoi vérifier votre email ?
                                </p>

                                <p class="mt-1 text-xs leading-5 text-slate-500">
                                    La vérification permet de confirmer que
                                    cette adresse vous appartient et protège
                                    votre compte contre les utilisations non
                                    autorisées.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Back home --}}
                    <div class="mt-8 text-center">

                        <a
                            href="{{ url('/') }}"
                            class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 transition hover:text-indigo-700"
                        >
                            ← Retour à Nexora
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>
</x-guest-layout>