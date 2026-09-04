<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    Utilisateurs
                </h2>

                <p class="text-sm text-slate-500">
                    Gestion des utilisateurs de la plateforme Nexora
                </p>
            </div>

            <a
                href="{{ route('users.create') }}"
                class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700"
            >
                + Ajouter un utilisateur
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Messages --}}
            @if (session('success'))
                <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Statistiques --}}
            <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">
                        Total utilisateurs
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-800">
                        {{ $users->total() }}
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">
                        Page actuelle
                    </p>

                    <p class="mt-2 text-3xl font-bold text-indigo-600">
                        {{ $users->count() }}
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">
                        Pages
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-800">
                        {{ $users->lastPage() }}
                    </p>
                </div>

            </div>

            {{-- Tableau --}}
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

                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Actions
                                </th>

                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @forelse ($users as $user)

                                <tr class="transition hover:bg-slate-50">

                                    {{-- Utilisateur --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        <div class="flex items-center gap-3">

                                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700">
                                                {{ strtoupper(substr($user->prenom, 0, 1) . substr($user->nom, 0, 1)) }}
                                            </div>

                                            <div>
                                                <p class="font-semibold text-slate-800">
                                                    {{ $user->prenom }} {{ $user->nom }}
                                                </p>

                                                <p class="text-xs text-slate-500">
                                                    ID #{{ $user->id }}
                                                </p>
                                            </div>

                                        </div>

                                    </td>

                                    {{-- Email --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                        {{ $user->email }}
                                    </td>

                                    {{-- Rôle --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        @forelse ($user->roles as $role)

                                            @php
                                                $roleClasses = match ($role->name) {
                                                    'admin' => 'bg-red-100 text-red-700',
                                                    'provider' => 'bg-indigo-100 text-indigo-700',
                                                    'client' => 'bg-emerald-100 text-emerald-700',
                                                    default => 'bg-slate-100 text-slate-700',
                                                };
                                            @endphp

                                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $roleClasses }}">
                                                {{ ucfirst($role->name) }}
                                            </span>

                                        @empty

                                            <span class="text-sm text-slate-400">
                                                Aucun rôle
                                            </span>

                                        @endforelse

                                    </td>

                                    {{-- Actions --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-right">

                                        <div class="flex justify-end gap-2">

                                            <a
                                                href="{{ route('users.show', $user) }}"
                                                class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900"
                                            >
                                                Voir
                                            </a>

                                            <a
                                                href="{{ route('users.edit', $user) }}"
                                                class="rounded-lg px-3 py-2 text-sm font-medium text-indigo-600 transition hover:bg-indigo-50"
                                            >
                                                Modifier
                                            </a>

                                            @if (auth()->id() !== $user->id)
                                                <form
                                                    action="{{ route('users.destroy', $user) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="rounded-lg px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50"
                                                    >
                                                        Supprimer
                                                    </button>
                                                </form>
                                            @endif

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">

                                        <div class="text-slate-400">
                                            Aucun utilisateur trouvé.
                                        </div>

                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- Pagination --}}
                @if ($users->hasPages())
                    <div class="border-t border-slate-200 px-6 py-4">
                        {{ $users->links() }}
                    </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>