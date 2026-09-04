<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Donner un avis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">

                    {{-- Service --}}
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold text-gray-900">
                            {{ $reservation->service->titre }}
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Prestataire :
                            {{ $reservation->service->user->prenom }}
                            {{ $reservation->service->user->nom }}
                        </p>

                        <p class="mt-2 text-sm text-gray-500">
                            Réservation du
                            {{ $reservation->date->format('d/m/Y H:i') }}
                        </p>
                    </div>

                    {{-- Errors --}}
                    @if ($errors->any())
                        <div class="mb-6 rounded-lg bg-red-100 p-4 text-red-700">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form --}}
                    <form method="POST" action="{{ route('avis.store') }}">
                        @csrf

                        {{-- Reservation ID --}}
                        <input
                            type="hidden"
                            name="reservation_id"
                            value="{{ $reservation->id }}"
                        >

                        {{-- Note --}}
                        <div class="mb-6">
                            <label
                                for="note"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Note
                            </label>

                            <select
                                id="note"
                                name="note"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                required
                            >
                                <option value="">Choisir une note</option>
                                <option value="5" {{ old('note') == 5 ? 'selected' : '' }}>
                                    5/5 ⭐⭐⭐⭐⭐
                                </option>
                                <option value="4" {{ old('note') == 4 ? 'selected' : '' }}>
                                    4/5 ⭐⭐⭐⭐
                                </option>
                                <option value="3" {{ old('note') == 3 ? 'selected' : '' }}>
                                    3/5 ⭐⭐⭐
                                </option>
                                <option value="2" {{ old('note') == 2 ? 'selected' : '' }}>
                                    2/5 ⭐⭐
                                </option>
                                <option value="1" {{ old('note') == 1 ? 'selected' : '' }}>
                                    1/5 ⭐
                                </option>
                            </select>

                            @error('note')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Commentaire --}}
                        <div class="mb-6">
                            <label
                                for="commentaire"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Commentaire
                            </label>

                            <textarea
                                id="commentaire"
                                name="commentaire"
                                rows="5"
                                maxlength="1000"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                placeholder="Donnez votre avis sur le service..."
                            >{{ old('commentaire') }}</textarea>

                            @error('commentaire')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="flex items-center gap-3">
                            <button
                                type="submit"
                                class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
                            >
                                Publier l'avis
                            </button>

                            <a
                                href="{{ route('reservations.show', $reservation) }}"
                                class="rounded-md bg-gray-200 px-4 py-2 text-gray-700 hover:bg-gray-300"
                            >
                                Annuler
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>