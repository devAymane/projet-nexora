<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-8">

        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8">

                <a
                    href="{{ route('categories.index') }}"
                    class="text-sm font-medium text-indigo-600 hover:text-indigo-700"
                >
                    ← Retour aux catégories
                </a>

                <h1 class="mt-4 text-3xl font-bold tracking-tight text-slate-900">
                    Modifier la catégorie
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    Modifiez les informations de cette catégorie.
                </p>

            </div>

            {{-- Validation errors --}}
            @if ($errors->any())

                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">

                    <p class="font-semibold text-red-700">
                        Veuillez corriger les erreurs suivantes :
                    </p>

                    <ul class="mt-2 list-inside list-disc text-sm text-red-600">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            @endif

            {{-- Form --}}
            <form
                action="{{ route('categories.update', $category) }}"
                method="POST"
                class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8"
            >

                @csrf
                @method('PUT')

                {{-- Nom --}}
                <div>

                    <label
                        for="nom"
                        class="block text-sm font-semibold text-slate-700"
                    >
                        Nom de la catégorie
                    </label>

                    <input
                        type="text"
                        id="nom"
                        name="nom"
                        value="{{ old('nom', $category->nom) }}"
                        required
                        maxlength="255"
                        class="mt-2 block w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >

                    @error('nom')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Description --}}
                <div class="mt-6">

                    <label
                        for="description"
                        class="block text-sm font-semibold text-slate-700"
                    >
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        class="mt-2 block w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >{{ old('description', $category->description) }}</textarea>

                    @error('description')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Actions --}}
                <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('categories.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                    >
                        Annuler
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700"
                    >
                        Enregistrer les modifications
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>