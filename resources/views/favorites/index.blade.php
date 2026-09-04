<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-8">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-900">
                    Mes favoris
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    Retrouvez les services que vous avez enregistrés.
                </p>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-xl bg-green-50 p-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if($favorites->count())

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

                    @foreach($favorites as $favorite)

                        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                            @if($favorite->service->image)
                                <img
                                    src="{{ asset('storage/' . $favorite->service->image) }}"
                                    alt="{{ $favorite->service->titre }}"
                                    class="h-48 w-full object-cover"
                                >
                            @else
                                <div class="flex h-48 items-center justify-center bg-slate-100 text-slate-400">
                                    Aucune image
                                </div>
                            @endif

                            <div class="p-5">

                                <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-600">
                                    {{ $favorite->service->category->nom }}
                                </span>

                                <h2 class="mt-3 text-lg font-bold text-slate-900">
                                    {{ $favorite->service->titre }}
                                </h2>

                                <p class="mt-2 text-sm text-slate-500">
                                    {{ Str::limit($favorite->service->description, 100) }}
                                </p>

                                <div class="mt-4 flex items-center justify-between">
                                    <span class="font-bold text-indigo-600">
                                        {{ number_format($favorite->service->prix, 2, ',', ' ') }} DH
                                    </span>

                                    <span class="text-sm text-slate-500">
                                        📍 {{ $favorite->service->ville }}
                                    </span>
                                </div>

                                <div class="mt-5 flex gap-2">

                                    <a
                                        href="{{ route('services.show', $favorite->service) }}"
                                        class="flex-1 rounded-xl bg-indigo-600 px-4 py-2 text-center text-sm font-semibold text-white hover:bg-indigo-700"
                                    >
                                        Voir
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('favorites.destroy', $favorite->service) }}"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-xl bg-red-50 px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-100"
                                        >
                                            ❤️
                                        </button>
                                    </form>

                                </div>

                            </div>
                        </div>

                    @endforeach

                </div>

                <div class="mt-8">
                    {{ $favorites->links() }}
                </div>

            @else

                <div class="rounded-2xl border border-slate-200 bg-white p-12 text-center">
                    <div class="text-5xl">⭐</div>

                    <h2 class="mt-4 text-xl font-bold text-slate-900">
                        Aucun favori
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">
                        Vous n'avez pas encore ajouté de service à vos favoris.
                    </p>

                    <a
                        href="{{ route('services.index') }}"
                        class="mt-6 inline-flex rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-700"
                    >
                        Découvrir les services
                    </a>
                </div>

            @endif

        </div>
    </div>

</x-app-layout>