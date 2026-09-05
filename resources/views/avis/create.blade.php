<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    Laisser un avis
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Partagez votre expérience avec ce service.
                </p>
            </div>

            <a href="{{ route('reservations.show', $reservation) }}"
               class="text-sm font-medium text-gray-600 hover:text-gray-900">
                ← Retour à la réservation
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">

            {{-- Errors --}}
            @if ($errors->any())
                <div class="mb-6 rounded-lg bg-red-50 p-4 text-sm text-red-700">
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Reservation summary --}}
            <div class="mb-6 rounded-xl bg-white p-6 shadow-sm">

                <p class="text-sm font-medium text-gray-500">
                    Service réservé
                </p>

                <h3 class="mt-2 text-xl font-bold text-gray-900">
                    {{ $reservation->service->titre }}
                </h3>

                <div class="mt-3 space-y-1 text-sm text-gray-600">

                    <p>
                        Prestataire :
                        <span class="font-medium text-gray-900">
                            {{ $reservation->service->user->prenom }}
                            {{ $reservation->service->user->nom }}
                        </span>
                    </p>

                    <p>
                        Date :
                        <span class="font-medium text-gray-900">
                            {{ $reservation->date->format('d/m/Y à H:i') }}
                        </span>
                    </p>

                    <p>
                        Statut :
                        <span class="font-medium text-green-600">
                            Terminée
                        </span>
                    </p>

                </div>

            </div>

            {{-- Review form --}}
            <div class="overflow-hidden rounded-xl bg-white shadow-sm">

                <div class="border-b border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Votre avis
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Évaluez votre expérience de 1 à 5 étoiles.
                    </p>
                </div>

                <form method="POST"
                      action="{{ route('avis.store') }}"
                      class="space-y-6 p-6">

                    @csrf

                    <input type="hidden"
                           name="reservation_id"
                           value="{{ $reservation->id }}">

                    {{-- Note --}}
                    <div>
                        <label for="note"
                               class="mb-2 block text-sm font-medium text-gray-700">
                            Note
                        </label>

                        <select name="note"
                                id="note"
                                required
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                            <option value="">-- Choisir une note --</option>

                            <option value="5" @selected(old('note') == 5)>
                                ⭐⭐⭐⭐⭐ — Excellent
                            </option>

                            <option value="4" @selected(old('note') == 4)>
                                ⭐⭐⭐⭐ — Très bien
                            </option>

                            <option value="3" @selected(old('note') == 3)>
                                ⭐⭐⭐ — Bien
                            </option>

                            <option value="2" @selected(old('note') == 2)>
                                ⭐⭐ — Moyen
                            </option>

                            <option value="1" @selected(old('note') == 1)>
                                ⭐ — Mauvais
                            </option>

                        </select>

                        @error('note')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Commentaire --}}
                    <div>
                        <label for="commentaire"
                               class="mb-2 block text-sm font-medium text-gray-700">
                            Commentaire
                        </label>

                        <textarea name="commentaire"
                                  id="commentaire"
                                  rows="6"
                                  maxlength="1000"
                                  required
                                  placeholder="Écrivez votre expérience..."
                                  class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('commentaire') }}</textarea>

                        <p class="mt-1 text-xs text-gray-500">
                            Maximum 1000 caractères.
                        </p>

                        @error('commentaire')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-end gap-3 border-t pt-6">

                        <a href="{{ route('reservations.show', $reservation) }}"
                           class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Annuler
                        </a>

                        <button type="submit"
                                class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-indigo-700">
                            Publier mon avis
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>