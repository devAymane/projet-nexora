<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-8">

        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            {{-- Back --}}
            <div class="mb-6">

                <a
                    href="{{ route('reservations.show', $reservation) }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-indigo-600"
                >
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>

                    Retour à la réservation
                </a>

            </div>


            {{-- Header --}}
            <div class="mb-8">

                <p class="text-sm font-semibold text-indigo-600">
                    Votre expérience
                </p>

                <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                    Laisser un avis
                </h1>

                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Partagez votre expérience avec la communauté Nexora.
                </p>

            </div>


            {{-- Service summary --}}
            <div class="mb-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="p-6">

                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center">

                        {{-- Icon --}}
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">

                            <svg
                                class="h-8 w-8"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M12 6v12m6-6H6"
                                />
                            </svg>

                        </div>


                        <div class="min-w-0 flex-1">

                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Service
                            </p>

                            <h2 class="mt-1 truncate text-xl font-bold text-slate-900">
                                {{ $reservation->service?->titre ?? 'Service' }}
                            </h2>

                            <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-slate-500">

                                @if($reservation->service?->category)

                                    <span>
                                        {{ $reservation->service->category->nom }}
                                    </span>

                                @endif

                                @if($reservation->service?->ville)

                                    <span>
                                        {{ $reservation->service->ville }}
                                    </span>

                                @endif

                                <span>
                                    Réservation #{{ $reservation->id }}
                                </span>

                            </div>

                        </div>


                        {{-- Status --}}
                        <div>

                            <span class="inline-flex items-center gap-2 rounded-full bg-green-50 px-4 py-2 text-sm font-semibold text-green-700">

                                <span class="h-2 w-2 rounded-full bg-green-500"></span>

                                Terminée

                            </span>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Form --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-100 px-6 py-5">

                    <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">
                        Votre avis
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-slate-900">
                        Comment s'est passée votre expérience ?
                    </h2>

                </div>


                <form
                    method="POST"
                    action="{{ route('avis.store') }}"
                    class="p-6"
                >

                    @csrf

                    <input
                        type="hidden"
                        name="reservation_id"
                        value="{{ $reservation->id }}"
                    >


                    {{-- Rating --}}
                    <div class="mb-8">

                        <label class="block text-sm font-semibold text-slate-900">
                            Votre note
                        </label>

                        <p class="mt-1 text-sm text-slate-500">
                            Choisissez une note de 1 à 5 étoiles.
                        </p>


                        <div class="mt-5 flex flex-row-reverse justify-end gap-2">

                            @for($i = 5; $i >= 1; $i--)

                                <input
                                    id="star-{{ $i }}"
                                    type="radio"
                                    name="note"
                                    value="{{ $i }}"
                                    class="peer hidden"
                                    {{ old('note') == $i ? 'checked' : '' }}
                                >

                                <label
                                    for="star-{{ $i }}"
                                    class="cursor-pointer text-4xl text-slate-200 transition hover:text-yellow-400 peer-checked:text-yellow-400"
                                    title="{{ $i }} étoile{{ $i > 1 ? 's' : '' }}"
                                >
                                    ★
                                </label>

                            @endfor

                        </div>


                        @error('note')

                            <p class="mt-3 text-sm font-medium text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Comment --}}
                    <div>

                        <label
                            for="commentaire"
                            class="block text-sm font-semibold text-slate-900"
                        >
                            Votre commentaire
                        </label>

                        <p class="mt-1 text-sm text-slate-500">
                            Expliquez brièvement ce que vous avez pensé du service.
                        </p>


                        <textarea
                            id="commentaire"
                            name="commentaire"
                            rows="6"
                            maxlength="2000"
                            placeholder="Partagez votre expérience..."
                            class="mt-4 block w-full rounded-xl border-slate-300 bg-slate-50 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500"
                        >{{ old('commentaire') }}</textarea>


                        @error('commentaire')

                            <p class="mt-2 text-sm font-medium text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Info --}}
                    <div class="mt-6 rounded-xl border border-indigo-100 bg-indigo-50 p-4">

                        <div class="flex items-start gap-3">

                            <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">

                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M13 16h-1v-4h-1m1-4h.01M12 22a10 10 0 100-20 10 10 0 000 20z"
                                    />
                                </svg>

                            </div>

                            <div>

                                <p class="text-sm font-semibold text-indigo-900">
                                    Votre avis compte
                                </p>

                                <p class="mt-1 text-xs leading-5 text-indigo-700">
                                    Votre évaluation aidera les autres utilisateurs à choisir les meilleurs prestataires sur Nexora.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Actions --}}
                    <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('reservations.show', $reservation) }}"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                        >
                            Annuler
                        </a>


                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >

                            <svg
                                class="h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>

                            Publier mon avis

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>