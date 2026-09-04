<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-8">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                        Catégories
                    </h1>

                    <p class="mt-2 text-sm text-slate-500">
                        Gérez les catégories de services de Nexora.
                    </p>
                </div>

                {{-- Add category --}}
                <a
                    href="{{ route('categories.create') }}"
                    class="inline-flex w-full items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 sm:w-auto"
                >
                    + Ajouter une catégorie
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

            {{-- Categories --}}
            @if($categories->count())

                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-slate-200">

                            <thead class="bg-slate-50">

                                <tr>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Nom
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Description
                                    </th>

                                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Services
                                    </th>

                                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Actions
                                    </th>

                                </tr>

                            </thead>

                            <tbody class="divide-y divide-slate-100 bg-white">

                                @foreach($categories as $category)

                                    <tr class="transition hover:bg-slate-50">

                                        {{-- Name --}}
                                        <td class="whitespace-nowrap px-6 py-5">

                                            <div class="font-semibold text-slate-900">
                                                {{ $category->nom }}
                                            </div>

                                        </td>

                                        {{-- Description --}}
                                        <td class="max-w-md px-6 py-5">

                                            <p class="line-clamp-2 text-sm text-slate-500">
                                                {{ $category->description ?: 'Aucune description' }}
                                            </p>

                                        </td>

                                        {{-- Services count --}}
                                        <td class="whitespace-nowrap px-6 py-5 text-center">

                                            <span class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-600">
                                                {{ $category->services_count }}
                                                {{ $category->services_count > 1 ? 'services' : 'service' }}
                                            </span>

                                        </td>

                                        {{-- Actions --}}
                                        <td class="whitespace-nowrap px-6 py-5">

                                            <div class="flex justify-end gap-2">

                                                {{-- Voir --}}
                                                <a
                                                    href="{{ route('categories.show', $category) }}"
                                                    class="rounded-lg bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200"
                                                >
                                                    Voir
                                                </a>

                                                {{-- Modifier --}}
                                                <a
                                                    href="{{ route('categories.edit', $category) }}"
                                                    class="rounded-lg bg-indigo-600 px-3 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700"
                                                >
                                                    Modifier
                                                </a>

                                                {{-- Supprimer --}}
                                                <form
                                                    action="{{ route('categories.destroy', $category) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');"
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

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

                {{-- Pagination --}}
                @if($categories->hasPages())

                    <div class="mt-8">
                        {{ $categories->links() }}
                    </div>

                @endif

            @else

                {{-- Empty state --}}
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center shadow-sm">

                    <div class="mx-auto max-w-md">

                        <h2 class="text-xl font-bold text-slate-900">
                            Aucune catégorie
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Aucune catégorie n'a encore été créée sur Nexora.
                        </p>

                        <a
                            href="{{ route('categories.create') }}"
                            class="mt-6 inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700"
                        >
                            + Ajouter une catégorie
                        </a>

                    </div>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>