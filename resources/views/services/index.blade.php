<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-8">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                        Services
                    </h1>

                    <p class="mt-2 text-sm text-slate-500">
                        Découvrez les services proposés sur Nexora.
                    </p>
                </div>

                {{-- Add service --}}
                @auth
                    @if(auth()->user()->hasRole('provider'))

                        <a
                            href="{{ route('services.create') }}"
                            class="inline-flex w-full items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 sm:w-auto"
                        >
                            + Ajouter un service
                        </a>

                    @endif
                @endauth

            </div>


            {{-- Success message --}}
            @if(session('success'))

                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                    {{ session('success') }}
                </div>

            @endif


            {{-- Services --}}
            @if($services->count())

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

                    @foreach($services as $service)

                        <article
                            class="flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg"
                        >

                            {{-- Image --}}
                            <div class="h-48 shrink-0 bg-slate-100">

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

                                {{-- Category --}}
                                <div class="mb-3">

                                    <span
                                        class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-600"
                                    >
                                        {{ $service->category->nom }}
                                    </span>

                                </div>


                                {{-- Title --}}
                                <h2 class="line-clamp-2 text-lg font-bold leading-6 text-slate-900">
                                    {{ $service->titre }}
                                </h2>


                                {{-- Description --}}
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
                                <div class="mt-2">

                                    <p class="text-sm text-slate-500">
                                        📍 {{ $service->ville }}
                                    </p>

                                </div>


                                {{-- Spacer --}}
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


                                {{-- Actions --}}
                                <div class="mt-4 space-y-2">

                                    {{-- Voir --}}
                                    <a
                                        href="{{ route('services.show', $service) }}"
                                        class="flex w-full items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700"
                                    >
                                        Voir le service
                                    </a>


                                    {{-- Owner / Admin actions --}}
                                    @auth

                                        @if(auth()->id() === $service->user_id || auth()->user()->hasRole('admin'))

                                            <div class="grid grid-cols-2 gap-2">

                                                {{-- Modifier --}}
                                                <a
                                                    href="{{ route('services.edit', $service) }}"
                                                    class="flex items-center justify-center rounded-xl bg-indigo-600 px-3 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                                                >
                                                    Modifier
                                                </a>


                                                {{-- Supprimer --}}
                                                <form
                                                    action="{{ route('services.destroy', $service) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?');"
                                                >

                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="w-full rounded-xl bg-red-600 px-3 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700"
                                                    >
                                                        Supprimer
                                                    </button>

                                                </form>

                                            </div>

                                        @endif

                                    @endauth

                                </div>

                            </div>

                        </article>

                    @endforeach

                </div>


                {{-- Pagination --}}
                @if($services->hasPages())

                    <div class="mt-8">
                        {{ $services->links() }}
                    </div>

                @endif


            @else

                {{-- Empty state --}}
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center shadow-sm">

                    <div class="mx-auto max-w-md">

                        <h2 class="text-xl font-bold text-slate-900">
                            Aucun service disponible
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Aucun service n'a encore été ajouté sur Nexora.
                        </p>


                        @auth

                            @if(auth()->user()->hasRole('provider'))

                                <a
                                    href="{{ route('services.create') }}"
                                    class="mt-6 inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700"
                                >
                                    + Ajouter un service
                                </a>

                            @endif

                        @endauth

                    </div>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>