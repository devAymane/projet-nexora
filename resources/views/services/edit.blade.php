<x-app-layout>
    <div class="min-h-screen bg-slate-50 py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8">
                <a
                    href="{{ route('services.show', $service) }}"
                    class="text-sm font-medium text-indigo-600 hover:text-indigo-700"
                >
                    ← Retour au service
                </a>

                <h1 class="mt-4 text-3xl font-bold text-slate-900">
                    Modifier le service
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Modifiez les informations de votre service.
                </p>
            </div>

            {{-- Errors --}}
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
                action="{{ route('services.update', $service) }}"
                method="POST"
                enctype="multipart/form-data"
                class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8"
            >
                @csrf
                @method('PUT')

                {{-- Titre --}}
                <div>
                    <label
                        for="titre"
                        class="block text-sm font-semibold text-slate-700"
                    >
                        Titre du service
                    </label>

                    <input
                        type="text"
                        id="titre"
                        name="titre"
                        value="{{ old('titre', $service->titre) }}"
                        required
                        class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </div>

                {{-- Category --}}
                <div class="mt-6">
                    <label
                        for="category_id"
                        class="block text-sm font-semibold text-slate-700"
                    >
                        Catégorie
                    </label>

                    <select
                        id="category_id"
                        name="category_id"
                        required
                        class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected(old('category_id', $service->category_id) == $category->id)
                            >
                                {{ $category->nom }}
                            </option>
                        @endforeach
                    </select>
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
                        rows="6"
                        required
                        class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >{{ old('description', $service->description) }}</textarea>
                </div>

                {{-- Prix + Ville --}}
                <div class="mt-6 grid gap-6 sm:grid-cols-2">

                    <div>
                        <label
                            for="prix"
                            class="block text-sm font-semibold text-slate-700"
                        >
                            Prix (DH)
                        </label>

                        <input
                            type="number"
                            id="prix"
                            name="prix"
                            value="{{ old('prix', $service->prix) }}"
                            min="0"
                            step="0.01"
                            required
                            class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                    </div>

                    <div>
                        <label
                            for="ville"
                            class="block text-sm font-semibold text-slate-700"
                        >
                            Ville
                        </label>

                        <input
                            type="text"
                            id="ville"
                            name="ville"
                            value="{{ old('ville', $service->ville) }}"
                            required
                            class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                    </div>

                </div>

                {{-- Image actuelle --}}
                @if($service->image)
                    <div class="mt-6">
                        <p class="mb-2 text-sm font-semibold text-slate-700">
                            Image actuelle
                        </p>

                        <img
                            src="{{ asset('storage/' . $service->image) }}"
                            alt="{{ $service->titre }}"
                            class="h-40 w-full rounded-xl object-cover sm:w-64"
                        >
                    </div>
                @endif

                {{-- Nouvelle image --}}
                <div class="mt-6">
                    <label
                        for="image"
                        class="block text-sm font-semibold text-slate-700"
                    >
                        Nouvelle image
                    </label>

                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept="image/*"
                        class="mt-2 block w-full rounded-xl border border-slate-300 bg-white text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:font-semibold file:text-indigo-600 hover:file:bg-indigo-100"
                    >

                    <p class="mt-2 text-xs text-slate-500">
                        Laissez vide pour conserver l'image actuelle.
                    </p>
                </div>

                {{-- Disponibilité --}}
                <div class="mt-6">
                    <label class="inline-flex items-center">
                        <input
                            type="checkbox"
                            name="disponibilite"
                            value="1"
                            @checked(old('disponibilite', $service->disponibilite))
                            class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        >

                        <span class="ml-2 text-sm text-slate-700">
                            Service disponible
                        </span>
                    </label>
                </div>

                {{-- Statut --}}
                <div class="mt-6">
                    <label
                        for="statut"
                        class="block text-sm font-semibold text-slate-700"
                    >
                        Statut
                    </label>

                    <select
                        id="statut"
                        name="statut"
                        required
                        class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option
                            value="brouillon"
                            @selected(old('statut', $service->statut) === 'brouillon')
                        >
                            Brouillon
                        </option>

                        <option
                            value="publie"
                            @selected(old('statut', $service->statut) === 'publie')
                        >
                            Publié
                        </option>

                        <option
                            value="suspendu"
                            @selected(old('statut', $service->statut) === 'suspendu')
                        >
                            Suspendu
                        </option>
                    </select>
                </div>

                {{-- Actions --}}
                <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('services.show', $service) }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
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