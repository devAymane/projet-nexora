<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nexora — Smart Freelance Marketplace</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900 antialiased">

    {{-- NAVBAR --}}
    <header class="fixed top-0 left-0 right-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-6 lg:px-8">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-600 text-lg font-bold text-white">
                    N
                </div>

                <span class="text-2xl font-bold tracking-tight text-slate-900">
                    Nexora
                </span>
            </a>

            {{-- Desktop navigation --}}
            <nav class="hidden items-center gap-8 md:flex">
                <a href="{{ url('/') }}"
                   class="text-sm font-medium text-indigo-600">
                    Accueil
                </a>

                <a href="{{ route('services.index') }}"
                   class="text-sm font-medium text-slate-600 transition hover:text-indigo-600">
                    Services
                </a>

                @auth
                    <a href="{{ route('reservations.index') }}"
                       class="text-sm font-medium text-slate-600 transition hover:text-indigo-600">
                        Réservations
                    </a>
                @endauth
            </nav>

            {{-- Auth --}}
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="hidden text-sm font-semibold text-slate-700 transition hover:text-indigo-600 sm:block">
                        Connexion
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                            S'inscrire
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </header>


    {{-- HERO --}}
    <main class="pt-20">

        <section class="relative overflow-hidden bg-white">
            <div class="absolute -left-40 -top-40 h-96 w-96 rounded-full bg-indigo-100 blur-3xl"></div>
            <div class="absolute -right-40 top-20 h-96 w-96 rounded-full bg-violet-100 blur-3xl"></div>

            <div class="relative mx-auto max-w-7xl px-6 py-24 lg:px-8 lg:py-32">

                <div class="mx-auto max-w-4xl text-center">

                    <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-indigo-100 bg-indigo-50 px-4 py-2 text-sm font-medium text-indigo-700">
                        <span class="h-2 w-2 rounded-full bg-indigo-600"></span>
                        La plateforme freelance nouvelle génération
                    </div>

                    <h1 class="text-5xl font-extrabold tracking-tight text-slate-900 sm:text-6xl lg:text-7xl">
                        Trouvez les
                        <span class="text-indigo-600"> meilleurs talents </span>
                        pour vos projets.
                    </h1>

                    <p class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-slate-600">
                        Nexora connecte clients et freelances qualifiés pour
                        transformer vos idées en projets réussis.
                    </p>


                    {{-- Search --}}
                    <form action="{{ route('services.index') }}"
                          method="GET"
                          class="mx-auto mt-10 flex max-w-3xl flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-3 shadow-xl shadow-slate-200/50 sm:flex-row">

                        <div class="flex flex-1 items-center gap-3 px-3">
                            <svg class="h-5 w-5 text-slate-400"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"/>
                            </svg>

                            <input
                                type="text"
                                name="search"
                                placeholder="Quel service recherchez-vous ?"
                                class="w-full border-0 bg-transparent py-3 text-sm text-slate-900 outline-none placeholder:text-slate-400 focus:ring-0"
                            >
                        </div>

                        <button type="submit"
                                class="rounded-xl bg-indigo-600 px-7 py-3 font-semibold text-white transition hover:bg-indigo-700">
                            Rechercher
                        </button>
                    </form>


                    <div class="mt-6 flex flex-wrap justify-center gap-3 text-sm text-slate-500">
                        <span>Populaire :</span>

                        <a href="{{ route('services.index') }}"
                           class="font-medium text-slate-700 hover:text-indigo-600">
                            Développement web
                        </a>

                        <span>•</span>

                        <a href="{{ route('services.index') }}"
                           class="font-medium text-slate-700 hover:text-indigo-600">
                            Design
                        </a>

                        <span>•</span>

                        <a href="{{ route('services.index') }}"
                           class="font-medium text-slate-700 hover:text-indigo-600">
                            Marketing
                        </a>
                    </div>

                </div>
            </div>
        </section>


        {{-- CATEGORIES --}}
        <section class="bg-slate-50 py-20">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">

                <div class="mb-12 flex items-end justify-between">
                    <div>
                        <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-indigo-600">
                            Explorez
                        </p>

                        <h2 class="text-3xl font-bold tracking-tight text-slate-900">
                            Découvrez nos catégories
                        </h2>

                        <p class="mt-3 text-slate-600">
                            Trouvez rapidement le service dont vous avez besoin.
                        </p>
                    </div>

                    <a href="{{ route('services.index') }}"
                       class="hidden text-sm font-semibold text-indigo-600 hover:text-indigo-700 sm:block">
                        Voir tous les services →
                    </a>
                </div>


                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

                    @php
                        $categories = [
                            ['icon' => '💻', 'name' => 'Développement Web'],
                            ['icon' => '🎨', 'name' => 'Design & Créatif'],
                            ['icon' => '📱', 'name' => 'Marketing Digital'],
                            ['icon' => '✍️', 'name' => 'Rédaction & Traduction'],
                            ['icon' => '📊', 'name' => 'Business'],
                            ['icon' => '🎬', 'name' => 'Vidéo & Animation'],
                            ['icon' => '📸', 'name' => 'Photographie'],
                            ['icon' => '⚙️', 'name' => 'Autres Services'],
                        ];
                    @endphp

                    @foreach ($categories as $category)
                        <a href="{{ route('services.index') }}"
                           class="group rounded-2xl border border-slate-200 bg-white p-6 transition duration-200 hover:-translate-y-1 hover:border-indigo-200 hover:shadow-lg">

                            <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-2xl">
                                {{ $category['icon'] }}
                            </div>

                            <h3 class="font-semibold text-slate-900 group-hover:text-indigo-600">
                                {{ $category['name'] }}
                            </h3>

                            <p class="mt-2 text-sm text-slate-500">
                                Explorer les services
                            </p>
                        </a>
                    @endforeach

                </div>
            </div>
        </section>


        {{-- WHY NEXORA --}}
        <section class="bg-white py-20">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">

                <div class="mx-auto max-w-2xl text-center">
                    <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-indigo-600">
                        Pourquoi Nexora ?
                    </p>

                    <h2 class="text-3xl font-bold tracking-tight text-slate-900">
                        Tout ce qu'il vous faut pour réussir
                    </h2>
                </div>


                <div class="mt-14 grid gap-8 md:grid-cols-3">

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-8">
                        <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100 text-2xl">
                            🔎
                        </div>

                        <h3 class="text-xl font-bold text-slate-900">
                            Trouvez facilement
                        </h3>

                        <p class="mt-3 leading-7 text-slate-600">
                            Recherchez parmi une large sélection de services
                            proposés par des freelances qualifiés.
                        </p>
                    </div>


                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-8">
                        <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100 text-2xl">
                            🛡️
                        </div>

                        <h3 class="text-xl font-bold text-slate-900">
                            Des profils fiables
                        </h3>

                        <p class="mt-3 leading-7 text-slate-600">
                            Consultez les profils, services et avis avant
                            de choisir votre prestataire.
                        </p>
                    </div>


                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-8">
                        <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100 text-2xl">
                            💬
                        </div>

                        <h3 class="text-xl font-bold text-slate-900">
                            Communiquez directement
                        </h3>

                        <p class="mt-3 leading-7 text-slate-600">
                            Échangez avec les freelances grâce à notre
                            système de messagerie intégré.
                        </p>
                    </div>

                </div>
            </div>
        </section>


        {{-- CTA --}}
        <section class="bg-indigo-600">
            <div class="mx-auto max-w-7xl px-6 py-20 text-center lg:px-8">

                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                    Prêt à lancer votre prochain projet ?
                </h2>

                <p class="mx-auto mt-4 max-w-2xl text-indigo-100">
                    Trouvez le freelance idéal ou proposez vos services
                    à des clients qui recherchent vos compétences.
                </p>

                <div class="mt-8 flex flex-col justify-center gap-4 sm:flex-row">

                    <a href="{{ route('services.index') }}"
                       class="rounded-xl bg-white px-7 py-3.5 font-semibold text-indigo-600 transition hover:bg-indigo-50">
                        Explorer les services
                    </a>

                    @guest
                        <a href="{{ route('register') }}"
                           class="rounded-xl border border-white/30 bg-indigo-500 px-7 py-3.5 font-semibold text-white transition hover:bg-indigo-400">
                            Créer un compte
                        </a>
                    @endguest

                </div>
            </div>
        </section>

    </main>


    {{-- FOOTER --}}
    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-6 py-10 lg:px-8">

            <div class="flex flex-col justify-between gap-6 sm:flex-row sm:items-center">

                <div>
                    <div class="flex items-center gap-2">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-600 font-bold text-white">
                            N
                        </div>

                        <span class="text-xl font-bold">
                            Nexora
                        </span>
                    </div>

                    <p class="mt-3 text-sm text-slate-500">
                        Smart Freelance Marketplace.
                    </p>
                </div>


                <div class="flex gap-6 text-sm text-slate-500">
                    <a href="{{ route('services.index') }}"
                       class="hover:text-indigo-600">
                        Services
                    </a>

                    @guest
                        <a href="{{ route('login') }}"
                           class="hover:text-indigo-600">
                            Connexion
                        </a>

                        <a href="{{ route('register') }}"
                           class="hover:text-indigo-600">
                            Inscription
                        </a>
                    @endguest
                </div>

            </div>

            <div class="mt-8 border-t border-slate-100 pt-6 text-sm text-slate-400">
                © {{ date('Y') }} Nexora. Tous droits réservés.
            </div>

        </div>
    </footer>

</body>
</html>