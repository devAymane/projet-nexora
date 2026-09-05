<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-8">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                        Utilisateurs
                    </h1>

                    <p class="mt-2 text-sm text-slate-500">
                        Gérez les utilisateurs et leurs rôles sur Nexora.
                    </p>
                </div>

                {{-- Add user --}}
                <a
                    href="{{ route('users.create') }}"
                    class="inline-flex w-full items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 sm:w-auto"
                >
                    + Ajouter un utilisateur
                </a>

            </div>


            {{-- Success message --}}
            @if(session('success'))

                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                    {{ session('success') }}
                </div>

            @endif


            {{-- Error message --}}
            @if(session('error'))

                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                    {{ session('error') }}
                </div>

            @endif


            {{-- Search & Filters --}}
            <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <form
                    action="{{ route('users.index') }}"
                    method="GET"
                    class="grid grid-cols-1 gap-4 md:grid-cols-4"
                >

                    {{-- Search --}}
                    <div class="md:col-span-2">

                        <label
                            for="search"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Rechercher
                        </label>

                        <input
                            id="search"
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Nom, prénom ou email..."
                            class="w-full rounded-xl border-slate-300 px-4 py-2.5 text-sm shadow-sm transition focus:border-indigo-500 focus:ring-indigo-500"
                        >

                    </div>


                    {{-- Role --}}
                    <div>

                        <label
                            for="role"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Rôle
                        </label>

                        <select
                            id="role"
                            name="role"
                            class="w-full rounded-xl border-slate-300 px-4 py-2.5 text-sm shadow-sm transition focus:border-indigo-500 focus:ring-indigo-500"
                        >

                            <option value="">
                                Tous les rôles
                            </option>

                            <option
                                value="admin"
                                @selected(request('role') === 'admin')
                            >
                                Administrateur
                            </option>

                            <option
                                value="provider"
                                @selected(request('role') === 'provider')
                            >
                                Prestataire
                            </option>

                            <option
                                value="client"
                                @selected(request('role') === 'client')
                            >
                                Client
                            </option>

                        </select>

                    </div>


                    {{-- Search buttons --}}
                    <div class="flex items-end gap-2">

                        <button
                            type="submit"
                            class="flex-1 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                        >
                            Rechercher
                        </button>

                        <a
                            href="{{ route('users.index') }}"
                            class="rounded-xl bg-slate-100 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-200"
                        >
                            Reset
                        </a>

                    </div>

                </form>

            </div>


            {{-- Users --}}
            @if($users->count())

                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-slate-200">

                            <thead class="bg-slate-50">

                                <tr>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Utilisateur
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Email
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Rôle
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Inscription
                                    </th>

                                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Actions
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-slate-100 bg-white">

                                @foreach($users as $user)

                                    @php
                                        $role = $user->roles->first()?->name;
                                    @endphp

                                    <tr class="transition hover:bg-slate-50">

                                        {{-- User --}}
                                        <td class="whitespace-nowrap px-6 py-5">

                                            <div class="flex items-center gap-3">

                                                {{-- Avatar --}}
                                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-slate-900 text-sm font-bold text-white">
                                                    {{ strtoupper(substr($user->prenom, 0, 1)) }}
                                                </div>


                                                <div>

                                                    <div class="flex items-center gap-2">

                                                        <p class="font-semibold text-slate-900">
                                                            {{ $user->prenom }} {{ $user->nom }}
                                                        </p>

                                                        @if(auth()->id() === $user->id)

                                                            <span class="rounded-full bg-slate-100 px-2 py-1 text-[10px] font-semibold text-slate-600">
                                                                Compte actuel
                                                            </span>

                                                        @endif

                                                    </div>

                                                    <p class="text-xs text-slate-400">
                                                        #{{ $user->id }}
                                                    </p>

                                                </div>

                                            </div>

                                        </td>


                                        {{-- Email --}}
                                        <td class="whitespace-nowrap px-6 py-5">

                                            <p class="text-sm text-slate-500">
                                                {{ $user->email }}
                                            </p>

                                        </td>


                                        {{-- Role --}}
                                        <td class="whitespace-nowrap px-6 py-5">

                                            @if($role === 'admin')

                                                <span class="inline-flex rounded-full bg-purple-50 px-3 py-1 text-xs font-semibold text-purple-600">
                                                    Administrateur
                                                </span>

                                            @elseif($role === 'provider')

                                                <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-600">
                                                    Prestataire
                                                </span>

                                            @else

                                                <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-600">
                                                    Client
                                                </span>

                                            @endif

                                        </td>


                                        {{-- Registration date --}}
                                        <td class="whitespace-nowrap px-6 py-5">

                                            <span class="text-sm text-slate-500">
                                                {{ $user->created_at?->format('d/m/Y') }}
                                            </span>

                                        </td>


                                        {{-- Actions --}}
                                        <td class="whitespace-nowrap px-6 py-5">

                                            <div class="flex justify-end gap-2">

                                                {{-- Voir --}}
                                                <a
                                                    href="{{ route('users.show', $user) }}"
                                                    class="rounded-lg bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200"
                                                >
                                                    Voir
                                                </a>


                                                {{-- Modifier informations --}}
                                                <a
                                                    href="{{ route('users.edit', $user) }}"
                                                    class="rounded-lg bg-indigo-600 px-3 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700"
                                                >
                                                    Modifier
                                                </a>


                                                @if(auth()->id() !== $user->id)

                                                    {{-- Role form --}}
                                                    <form
                                                        action="{{ route('users.update-role', $user) }}"
                                                        method="POST"
                                                        class="flex items-center gap-2"
                                                    >

                                                        @csrf

                                                        @method('PATCH')


                                                        <select
                                                            name="role"
                                                            class="rounded-lg border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                        >

                                                            <option
                                                                value="client"
                                                                @selected($role === 'client')
                                                            >
                                                                Client
                                                            </option>

                                                            <option
                                                                value="provider"
                                                                @selected($role === 'provider')
                                                            >
                                                                Prestataire
                                                            </option>

                                                            <option
                                                                value="admin"
                                                                @selected($role === 'admin')
                                                            >
                                                                Administrateur
                                                            </option>

                                                        </select>


                                                        <button
                                                            type="submit"
                                                            class="rounded-lg bg-indigo-600 px-3 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700"
                                                        >
                                                            Rôle
                                                        </button>

                                                    </form>


                                                    {{-- Delete --}}
                                                    <form
                                                        action="{{ route('users.destroy', $user) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');"
                                                    >

                                                        @csrf

                                                        @method('DELETE')

                                                        <button
                                                            type="submit"
                                                            class="rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white transition hover:bg-red-700"
                                                        >
                                                            Supprimer
                                                        </button>

                                                    </form>

                                                @endif

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>


                {{-- Pagination --}}
                @if($users->hasPages())

                    <div class="mt-8">
                        {{ $users->links() }}
                    </div>

                @endif


            @else

                {{-- Empty state --}}
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center shadow-sm">

                    <div class="mx-auto max-w-md">

                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-indigo-50 text-indigo-600">

                            <svg
                                class="h-7 w-7"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M15 19a4 4 0 00-8 0m4-6a4 4 0 100-8 4 4 0 000 8zm6 6a3 3 0 00-2.5-2.95M17 11a3 3 0 100-6"
                                />
                            </svg>

                        </div>


                        <h2 class="mt-5 text-xl font-bold text-slate-900">
                            Aucun utilisateur
                        </h2>


                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Aucun utilisateur ne correspond à votre recherche.
                        </p>


                        <a
                            href="{{ route('users.create') }}"
                            class="mt-6 inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700"
                        >
                            + Ajouter un utilisateur
                        </a>

                    </div>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>