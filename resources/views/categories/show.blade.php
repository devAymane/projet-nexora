<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-8">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8">

                <a
                    href="{{ route('categories.index') }}"
                    class="text-sm font-medium text-indigo-600 hover:text-indigo-700"
                >
                    ← Retour aux catégories
                </a>

                <div class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                    <div>

                        <span class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-600">
                            Catégorie
                        </span>

                        <h1 class="mt-3 text-3xl font-bold tracking-tight text-slate-900">
                            {{ $category->nom }}
                        </h1>

                        <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                            {{ $category->description ?: 'Aucune description disponible.' }}
                        </p>

                    </div>

                    <div class="flex gap-2">

                        <a
                            href="{{ route('categories.edit', $category) }}"
                            class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700"
                        >
                            Modifier
                        </a>

                    </div>

                </div>

            </div>

            {{-- Stats --}}
            <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2">

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                    <p class="text-sm font-medium text-slate-500">
                        Nombre de services
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ $category->services->count() }}
                    </p>

                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                    <p class="text-sm font-medium text-slate-500">
                        Catégorie créée le
                    </p>

                    <p class="mt-2 text-lg font-bold text-slate-900">
                        {{ $category->created_at->format('d/m/Y') }}
                    </p>

                </div>

            </div>

            {{-- Services --}}
            <div>

                <div class="mb-5">

                    <h2 class="text-2xl font-bold text-slate-900">
                        Services de cette catégorie
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Découvrez les services associés à {{ $category->nom }}.
                    </p>

                </div>

                @if($category->services->count())

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

                        @foreach($category->services as $service)

                            <article
                                class="flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg"
                            >

                                {{-- Image --}}
                                <div class="h-44 shrink-0 bg-slate-100">

                                    @if($service->image)

                                        <img
                                            src="{{ asset('storage/' . $service->image) }}"
                                            alt="{{ $service->titre }}"
                                            class="h-full w-full object-cover"
                                        >

                                    @else

                                        <div class="flex h-full items-center justify-center">

                                            <span class="text-sm font-medium text-slate-400">
                                                Aucune image
                                            </span>

                                        </div>

                                    @endif

                                </div>

                                {{-- Content --}}
                                <div class="flex flex-1 flex-col p-5">

                                    <h3 class="line-clamp-2 text-lg font-bold leading-6 text-slate-900">
                                        {{ $service->titre }}
                                    </h3>

                                    <p class="mt-2 line-clamp-3 text-sm leading-6 text-slate-500">
                                        {{ $service->description }}
                                    </p>

                                    {{-- Provider --}}
                                    <div class="mt-4">

                                        <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                            Prestataire
                                        </p>

                                        <p class="mt-1 text-sm font-semibold text-slate-700">
                                            {{ $service->user->prenom }}
                                            {{ $service->user->nom }}
                                        </p>

                                    </div>

                                    {{-- City --}}
                                    <p class="mt-2 text-sm text-slate-500">
                                        📍 {{ $service->ville }}
                                    </p>

                                    <div class="flex-1"></div>

                                    {{-- Price --}}
                                    <div class="mt-5 border-t border-slate-100 pt-4">

                                        <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                            Prix
                                        </p>

                                        <p class="mt-1 text-2xl font-bold text-indigo-600">
                                            {{ number_format($service->prix, 2, ',', ' ') }}
                                            <span class="text-base font-semibold">
                                                DH
                                            </span>
                                        </p>

                                    </div>

                                    {{-- Action --}}
                                    <a
                                        href="{{ route('services.show', $service) }}"
                                        class="mt-4 flex w-full items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700"
                                    >
                                        Voir le service
                                    </a>

                                </div>

                            </article>

                        @endforeach

                    </div>

                @else

                    {{-- Empty state --}}
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center shadow-sm">

                        <div class="mx-auto max-w-md">

                            <h3 class="text-xl font-bold text-slate-900">
                                Aucun service
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-slate-500">
                                Aucun service n'est encore associé à cette catégorie.
                            </p>

                        </div>

                    </div>

                @endif

            </div>

            {{-- Back --}}
            <div class="mt-8">

                <a
                    href="{{ route('categories.index') }}"
                    class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-700"
                >
                    ← Retour à la liste des catégories
                </a>

            </div>

        </div>

    </div>

</x-app-layout>