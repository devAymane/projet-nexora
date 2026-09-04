<x-app-layout>
    <div class="min-h-screen bg-slate-50 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">
                        Services
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Découvrez les services proposés sur Nexora.
                    </p>
                </div>

                @auth
                    @if(auth()->user()->hasRole('provider'))
                        <a
                            href="{{ route('services.create') }}"
                            class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700"
                        >
                            + Ajouter un service
                        </a>
                    @endif
                @endauth
            </div>

            {{-- Success message --}}
            @if(session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Services --}}
            @if($services->count())
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

                    @foreach($services as $service)

                        <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">

                            {{-- Image --}}
                            <div class="h-48 bg-slate-100">

                                @if($service->image)
                                    <img
                                        src="{{ asset('storage/' . $service->image) }}"
                                        alt="{{ $service->titre }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    <div class="flex h-full items-center justify-center text-slate-400">
                                        <span class="text-sm">
                                            Aucune image
                                        </span>
                                    </div>
                                @endif

                            </div>

                            {{-- Content --}}
                            <div class="p-5">

                                {{-- Category --}}
                                <div class="mb-2">
                                    <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-600">
                                        {{ $service->category->nom }}
                                    </span>
                                </div>

                                {{-- Title --}}
                                <h2 class="line-clamp-2 text-lg font-bold text-slate-900">
                                    {{ $service->titre }}
                                </h2>

                                {{-- Description --}}
                                <p class="mt-2 line-clamp-3 text-sm text-slate-500">
                                    {{ $service->description }}
                                </p>

                                {{-- Provider --}}
                                <div class="mt-4 flex items-center gap-2 text-sm text-slate-500">
                                    <span class="font-medium text-slate-700">
                                        {{ $service->user->prenom }}
                                        {{ $service->user->nom }}
                                    </span>
                                </div>

                                {{-- City --}}
                                <p class="mt-1 text-sm text-slate-500">
                                    📍 {{ $service->ville }}
                                </p>

                                {{-- Bottom --}}
                                <div class="mt-5 flex items-center justify-between">

                                    <span class="text-lg font-bold text-indigo-600">
                                        {{ number_format($service->prix, 2, ',', ' ') }} DH
                                    </span>

                                    <a
                                        href="{{ route('services.show', $service) }}"
                                        class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-700"
                                    >
                                        Voir
                                    </a>

                                </div>

                            </div>
                        </article>

                    @endforeach

                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $services->links() }}
                </div>

            @else

                <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">
                    <h2 class="text-xl font-semibold text-slate-900">
                        Aucun service disponible
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">
                        Aucun service n'a encore été ajouté sur Nexora.
                    </p>
                </div>

            @endif

        </div>
    </div>
</x-app-layout>