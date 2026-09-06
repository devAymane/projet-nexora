<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center min-h-16 sm:h-20 py-2 sm:py-0">

            {{-- LEFT --}}
            <div class="flex items-center gap-4 sm:gap-10 min-w-0">

                {{-- Logo --}}
                <a href="{{ route('services.index') }}" class="flex items-center gap-2 shrink-0">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-indigo-600 flex items-center justify-center">
                        <span class="text-white font-bold text-lg sm:text-xl">N</span>
                    </div>

                    <span class="text-xl sm:text-2xl font-bold text-gray-900">
                        Nexora
                    </span>
                </a>

                {{-- Desktop Navigation --}}
                <div class="hidden lg:flex items-center gap-5 xl:gap-7">

                    {{-- Guest --}}
                    @guest
                        <a href="{{ route('services.index') }}"
                           class="text-sm font-medium transition
                           {{ request()->routeIs('services.index') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}">
                            Services
                        </a>

                        <a href="{{ route('login') }}"
                           class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition">
                            Comment ça marche
                        </a>
                    @endguest


                    {{-- Client --}}
                    @auth
                        @if(auth()->user()->hasRole('client'))

                            <a href="{{ route('services.index') }}"
                               class="text-sm font-medium transition
                               {{ request()->routeIs('services.*') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}">
                                Services
                            </a>

                            <a href="{{ route('reservations.index') }}"
                               class="text-sm font-medium transition
                               {{ request()->routeIs('reservations.*') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}">
                                Réservations
                            </a>

                            <a href="{{ route('favorites.index') }}"
                               class="text-sm font-medium transition
                               {{ request()->routeIs('favorites.*') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}">
                                Favoris
                            </a>

                            <a href="{{ route('conversations.index') }}"
                               class="text-sm font-medium transition
                               {{ request()->routeIs('conversations.*') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}">
                                Messages
                            </a>

                        @elseif(auth()->user()->hasRole('provider'))

                            {{-- Provider --}}

                            <a href="{{ route('services.index') }}"
                               class="text-sm font-medium transition
                               {{ request()->routeIs('services.index') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}">
                                Services
                            </a>

                            <a href="{{ route('services.create') }}"
                               class="text-sm font-medium transition
                               {{ request()->routeIs('services.create') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}">
                                Mes services
                            </a>

                            <a href="{{ route('reservations.index') }}"
                               class="text-sm font-medium transition
                               {{ request()->routeIs('reservations.*') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}">
                                Réservations
                            </a>

                            <a href="{{ route('conversations.index') }}"
                               class="text-sm font-medium transition
                               {{ request()->routeIs('conversations.*') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}">
                                Messages
                            </a>

                        @elseif(auth()->user()->hasRole('admin'))

                            {{-- Admin --}}

                            <a href="{{ route('admin.dashboard') }}"
                               class="text-sm font-medium transition
                               {{ request()->routeIs('admin.dashboard') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}">
                                Dashboard
                            </a>

                            <a href="{{ route('users.index') }}"
                               class="text-sm font-medium transition
                               {{ request()->routeIs('users.*') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}">
                                Utilisateurs
                            </a>

                            <a href="{{ route('categories.index') }}"
                               class="text-sm font-medium transition
                               {{ request()->routeIs('categories.*') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}">
                                Catégories
                            </a>

                            <a href="{{ route('services.index') }}"
                               class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition">
                                Services
                            </a>

                            <a href="{{ route('reservations.index') }}"
                               class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition">
                                Réservations
                            </a>

                            <a href="{{ route('avis.index') }}"
                               class="text-sm font-medium transition
                               {{ request()->routeIs('avis.*') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}">
                                Avis
                            </a>

                        @endif
                    @endauth

                </div>
            </div>


            {{-- RIGHT --}}
            <div class="hidden lg:flex items-center gap-3 xl:gap-5">

                @guest

                    {{-- Guest --}}
                    <a href="{{ route('login') }}"
                       class="text-sm font-semibold text-gray-700 hover:text-indigo-600 transition">
                        Connexion
                    </a>

                    <a href="{{ route('register') }}"
                       class="px-4 xl:px-5 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition shadow-sm whitespace-nowrap">
                        S'inscrire
                    </a>

                @else

                    {{-- Notifications --}}
                    <a href="{{ route('notifications.index') }}"
                       class="relative w-10 h-10 rounded-xl flex items-center justify-center
                              text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.8"
                             stroke="currentColor"
                             class="w-5 h-5">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M14.857 17.082a23.848 23.848 0 0 1-5.714 0
                                     A3.375 3.375 0 0 1 6.75 13.77V10.5
                                     a5.25 5.25 0 0 1 10.5 0v3.27
                                     a3.375 3.375 0 0 1-2.393 3.312Z" />

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M9.75 17.25a2.25 2.25 0 0 0 4.5 0" />
                        </svg>

                        @php
                            $unreadNotificationsCount = auth()->user()
                                ->unreadNotifications()
                                ->count();
                        @endphp

                        @if($unreadNotificationsCount > 0)
                            <span class="absolute -top-1 -right-1 min-w-[19px] h-[19px]
                                         px-1 rounded-full bg-red-500 text-white
                                         text-[10px] font-bold flex items-center justify-center">
                                {{ $unreadNotificationsCount > 99 ? '99+' : $unreadNotificationsCount }}
                            </span>
                        @endif
                    </a>


                    {{-- User Dropdown --}}
                    <x-dropdown align="right" width="56">

                        <x-slot name="trigger">

                            <button
                                class="flex items-center gap-2 sm:gap-3 px-2 py-1.5 rounded-xl
                                       hover:bg-gray-50 transition focus:outline-none">

                                {{-- Avatar --}}
                                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-indigo-100
                                            flex items-center justify-center shrink-0">

                                    <span class="text-indigo-700 font-bold">
                                        {{ strtoupper(substr(auth()->user()->prenom, 0, 1)) }}
                                    </span>
                                </div>

                                {{-- Name --}}
                                <div class="text-left hidden xl:block">

                                    <div class="text-sm font-semibold text-gray-900">
                                        {{ auth()->user()->prenom }} {{ auth()->user()->nom }}
                                    </div>

                                    <div class="text-xs text-gray-500">
                                        @if(auth()->user()->hasRole('admin'))
                                            Administrateur
                                        @elseif(auth()->user()->hasRole('provider'))
                                            Freelance
                                        @else
                                            Client
                                        @endif
                                    </div>

                                </div>

                                <svg class="w-4 h-4 text-gray-400"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M19 9l-7 7-7-7" />
                                </svg>

                            </button>

                        </x-slot>


                        <x-slot name="content">

                            {{-- User header --}}
                            <div class="px-4 py-3 border-b border-gray-100">

                                <p class="text-sm font-semibold text-gray-900">
                                    {{ auth()->user()->prenom }} {{ auth()->user()->nom }}
                                </p>

                                <p class="text-xs text-gray-500 mt-1 break-all">
                                    {{ auth()->user()->email }}
                                </p>

                            </div>


                            {{-- Dashboard --}}
                            <x-dropdown-link :href="route('dashboard')">
                                📊 Dashboard
                            </x-dropdown-link>


                            {{-- Profile --}}
                            <x-dropdown-link :href="route('profile.edit')">
                                👤 Mon profil
                            </x-dropdown-link>


                            {{-- Notifications --}}
                            <x-dropdown-link :href="route('notifications.index')">
                                🔔 Notifications
                            </x-dropdown-link>


                            {{-- Logout --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link
                                    :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                >
                                    🚪 Déconnexion
                                </x-dropdown-link>
                            </form>

                        </x-slot>

                    </x-dropdown>

                @endguest

            </div>


            {{-- Mobile button --}}
            <div class="lg:hidden shrink-0">

                <button
                    @click="open = !open"
                    :aria-expanded="open"
                    aria-label="Ouvrir le menu"
                    class="w-10 h-10 rounded-xl flex items-center justify-center
                           text-gray-600 hover:bg-gray-100 active:bg-gray-200 transition">

                    <svg x-show="!open"
                         xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="2"
                         stroke="currentColor"
                         class="w-6 h-6">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M4 6h16M4 12h16M4 18h16" />
                    </svg>

                    <svg x-show="open"
                         xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="2"
                         stroke="currentColor"
                         class="w-6 h-6">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>

                </button>

            </div>

        </div>
    </div>


    {{-- MOBILE MENU --}}
    <div
        x-show="open"
        x-transition
        class="lg:hidden border-t border-gray-100 bg-white shadow-sm">

        <div class="px-3 sm:px-4 py-4 sm:py-5 space-y-2 max-h-[calc(100vh-4rem)] overflow-y-auto">

            @guest

                <a href="{{ route('services.index') }}"
                   class="block px-4 py-3 rounded-xl text-sm font-medium
                          text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 active:bg-indigo-100 transition">
                    Services
                </a>

                <a href="{{ route('login') }}"
                   class="block px-4 py-3 rounded-xl text-sm font-medium
                          text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 active:bg-indigo-100 transition">
                    Connexion
                </a>

                <a href="{{ route('register') }}"
                   class="block px-4 py-3 rounded-xl bg-indigo-600 text-white text-sm font-semibold
                          hover:bg-indigo-700 active:bg-indigo-800 transition text-center">
                    S'inscrire
                </a>

            @else

                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                   class="block px-4 py-3 rounded-xl text-sm font-medium
                          text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 active:bg-indigo-100 transition">
                    📊 Dashboard
                </a>

                {{-- Services --}}
                <a href="{{ route('services.index') }}"
                   class="block px-4 py-3 rounded-xl text-sm font-medium
                          text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 active:bg-indigo-100 transition">
                    🛍️ Services
                </a>

                {{-- Client --}}
                @if(auth()->user()->hasRole('client'))

                    <a href="{{ route('reservations.index') }}"
                       class="block px-4 py-3 rounded-xl text-sm font-medium
                              text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 active:bg-indigo-100 transition">
                        📅 Réservations
                    </a>

                    <a href="{{ route('favorites.index') }}"
                       class="block px-4 py-3 rounded-xl text-sm font-medium
                              text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 active:bg-indigo-100 transition">
                        ❤️ Favoris
                    </a>

                    <a href="{{ route('conversations.index') }}"
                       class="block px-4 py-3 rounded-xl text-sm font-medium
                              text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 active:bg-indigo-100 transition">
                        💬 Messages
                    </a>

                {{-- Provider --}}
                @elseif(auth()->user()->hasRole('provider'))

                    <a href="{{ route('services.create') }}"
                       class="block px-4 py-3 rounded-xl text-sm font-medium
                              text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 active:bg-indigo-100 transition">
                        ➕ Mes services
                    </a>

                    <a href="{{ route('reservations.index') }}"
                       class="block px-4 py-3 rounded-xl text-sm font-medium
                              text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 active:bg-indigo-100 transition">
                        📅 Réservations
                    </a>

                    <a href="{{ route('conversations.index') }}"
                       class="block px-4 py-3 rounded-xl text-sm font-medium
                              text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 active:bg-indigo-100 transition">
                        💬 Messages
                    </a>

                {{-- Admin --}}
                @elseif(auth()->user()->hasRole('admin'))

                    <a href="{{ route('users.index') }}"
                       class="block px-4 py-3 rounded-xl text-sm font-medium
                              text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 active:bg-indigo-100 transition">
                        👥 Utilisateurs
                    </a>

                    <a href="{{ route('categories.index') }}"
                       class="block px-4 py-3 rounded-xl text-sm font-medium
                              text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 active:bg-indigo-100 transition">
                        📂 Catégories
                    </a>

                    <a href="{{ route('reservations.index') }}"
                       class="block px-4 py-3 rounded-xl text-sm font-medium
                              text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 active:bg-indigo-100 transition">
                        📅 Réservations
                    </a>

                    <a href="{{ route('avis.index') }}"
                       class="block px-4 py-3 rounded-xl text-sm font-medium
                              text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 active:bg-indigo-100 transition">
                        ⭐ Avis
                    </a>

                @endif


                <div class="border-t border-gray-100 pt-3 mt-3">

                    <a href="{{ route('notifications.index') }}"
                       class="flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium
                              text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 active:bg-indigo-100 transition">

                        <span>🔔 Notifications</span>

                        @if($unreadNotificationsCount > 0)
                            <span class="text-xs bg-red-500 text-white px-2 py-1 rounded-full">
                                {{ $unreadNotificationsCount > 99 ? '99+' : $unreadNotificationsCount }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('profile.edit') }}"
                       class="block px-4 py-3 rounded-xl text-sm font-medium
                              text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 active:bg-indigo-100 transition">
                        👤 Mon profil
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                                class="w-full text-left px-4 py-3 rounded-xl text-sm
                                       font-medium text-red-600 hover:bg-red-50 active:bg-red-100 transition">
                            🚪 Déconnexion
                        </button>
                    </form>

                </div>

            @endguest

        </div>
    </div>
</nav>