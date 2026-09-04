<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">
                Ajouter un avis
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Partagez votre expérience concernant ce service.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">
                    <ul class="list-inside list-disc text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Reservation information --}}
            <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h3 class="text-lg font-bold text-slate-800">
                    {{ $reservation->service->titre }}
                </h3>

                <div class="mt-4 grid gap-4 sm:grid-cols-2">

                    <div>
                        <span class="text-sm text-slate-500">
                            Prestataire
                        </span>

                        <p class="font-semibold text-slate-800">
                            {{ $reservation->service->user->prenom }}
                            {{ $reservation->service->user->nom }}
                        </p>
                    </div>

                    <div>
                        <span class="text-sm text-slate-500">
                            Date de réservation
                        </span>

                        <p class="font-semibold text-slate-800">
                            {{ $reservation->date->format('d/m/Y à H:i') }}
                        </p>
                    </div>

                </div>

            </div>


            {{-- Avis form --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <form
                    method="POST"
                    action="{{ route('avis.store') }}"
                    class="space-y-6"
                >
                    @csrf

                    <input
                        type="hidden"
                        name="reservation_id"
                        value="{{ $reservation->id }}"
                    >

                    {{-- Note --}}
                    <div>
                        <label
                            for="note"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Note
                        </label>

                        <select
                            id="note"
                            name="note"
                            required
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="">Choisissez une note</option>
                            <option value="1" {{ old('note') == 1 ? 'selected' : '' }}>
                                1 / 5 ⭐
                            </option>
                            <option value="2" {{ old('note') == 2 ? 'selected' : '' }}>
                                2 / 5 ⭐⭐
                            </option>
                            <option value="3" {{ old('note') == 3 ? 'selected' : '' }}>
                                3 / 5 ⭐⭐⭐
                            </option>
                            <option value="4" {{ old('note') == 4 ? 'selected' : '' }}>
                                4 / 5 ⭐⭐⭐⭐
                            </option>
                            <option value="5" {{ old('note') == 5 ? 'selected' : '' }}>
                                5 / 5 ⭐⭐⭐⭐⭐
                            </option>
                        </select>

                        @error('note')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>


                    {{-- Commentaire --}}
                    <div>
                        <label
                            for="commentaire"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Commentaire
                        </label>

                        <textarea
                            id="commentaire"
                            name="commentaire"
                            rows="5"
                            maxlength="1000"
                            placeholder="Partagez votre expérience..."
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-indigo-500 focus:ring-indigo-500"
                        >{{ old('commentaire') }}</textarea>

                        @error('commentaire')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>


                    {{-- Buttons --}}
                    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('reservations.show', $reservation) }}"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                        >
                            Annuler
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-6 py-3 text-sm font-bold text-white transition hover:bg-indigo-700"
                        >
                            Publier mon avis
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>