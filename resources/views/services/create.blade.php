<x-app-layout>
    <div class="min-h-screen bg-slate-50 py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8">
                <a
                    href="{{ route('services.index') }}"
                    class="text-sm font-medium text-indigo-600 hover:text-indigo-700"
                >
                    ← Retour aux services
                </a>

                <h1 class="mt-4 text-3xl font-bold text-slate-900">
                    Ajouter un service
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Présentez votre service aux clients de Nexora.
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
                action="{{ route('services.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8"
            >
                @csrf

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
                        value="{{ old('titre') }}"
                        required
                        placeholder="Ex : Création d'un site web professionnel"
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
                        <option value="">
                            Sélectionnez une catégorie
                        </option>

                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected(old('category_id') == $category->id)
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
                        placeholder="Décrivez votre service..."
                        class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >{{ old('description') }}</textarea>
                </div>

                {{-- Price + City --}}
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
                            value="{{ old('prix') }}"
                            min="0"
                            step="0.01"
                            required
                            placeholder="500.00"
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
                            value="{{ old('ville') }}"
                            required
                            placeholder="Ex : Casablanca"
                            class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                    </div>

                </div>

                {{-- Image --}}
                <div class="mt-6">
                    <label
                        for="image"
                        class="block text-sm font-semibold text-slate-700"
                    >
                        Image du service
                    </label>

                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept="image/*"
                        class="mt-2 block w-full rounded-xl border border-slate-300 bg-white text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:font-semibold file:text-indigo-600 hover:file:bg-indigo-100"
                    >

                    <p class="mt-2 text-xs text-slate-500">
                        Formats image acceptés. Taille maximale : 2 MB.
                    </p>
                </div>

                {{-- Disponibilité --}}
                <div class="mt-6">
                    <label class="inline-flex items-center">
                        <input
                            type="checkbox"
                            name="disponibilite"
                            value="1"
                            @checked(old('disponibilite', true))
                            class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        >

                        <span class="ml-2 text-sm text-slate-700">
                            Service disponible
                        </span>
                    </label>
                </div>

                {{-- Actions --}}
                <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('services.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                    >
                        Annuler
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700"
                    >
                        Créer le service
                    </button>

                </div>

            </form>
        </div>
    </div>
</x-app-layout>