<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-8">

        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8">

                <a
                    href="{{ route('services.index') }}"
                    class="text-sm font-medium text-slate-600 hover:text-indigo-600"
                >
                    ← Retour aux services
                </a>

                <h1 class="mt-4 text-3xl font-bold text-slate-900">
                    Réserver un service
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    Remplissez les informations pour envoyer votre demande.
                </p>

            </div>


            {{-- Errors --}}
            @if($errors->any())

                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">

                    <ul class="list-disc space-y-1 pl-5">

                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- Selected service --}}
            @if($service)

                <div class="mb-6 overflow-hidden rounded-2xl border border-indigo-100 bg-white shadow-sm">

                    <div class="flex flex-col sm:flex-row">

                        {{-- Image --}}
                        <div class="h-48 w-full bg-slate-100 sm:h-auto sm:w-48">

                            @if($service->image)

                                <img
                                    src="{{ asset('storage/' . $service->image) }}"
                                    alt="{{ $service->titre }}"
                                    class="h-full w-full object-cover"
                                >

                            @else

                                <div class="flex h-full items-center justify-center">
                                    <span class="text-sm text-slate-400">
                                        Aucune image
                                    </span>
                                </div>

                            @endif

                        </div>


                        {{-- Info --}}
                        <div class="flex-1 p-5">

                            <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-600">
                                {{ $service->category->nom }}
                            </span>

                            <h2 class="mt-3 text-xl font-bold text-slate-900">
                                {{ $service->titre }}
                            </h2>

                            <p class="mt-2 text-sm text-slate-500">
                                Prestataire :
                                <span class="font-semibold text-slate-700">
                                    {{ $service->user->prenom }}
                                    {{ $service->user->nom }}
                                </span>
                            </p>

                            <p class="mt-2 text-lg font-bold text-indigo-600">
                                {{ number_format($service->prix, 2, ',', ' ') }} DH
                            </p>

                        </div>

                    </div>

                </div>

            @endif


            {{-- Reservation form --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

                <form
                    method="POST"
                    action="{{ route('reservations.store') }}"
                >

                    @csrf


                    {{-- Service --}}
                    <div>

                        <label
                            for="service_id"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Service
                        </label>

                        <select
                            id="service_id"
                            name="service_id"
                            required
                            class="w-full rounded-xl border-slate-300 px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500"
                        >

                            <option value="">
                                Sélectionner un service
                            </option>

                            @foreach($services as $item)

                                <option
                                    value="{{ $item->id }}"
                                    @selected(old('service_id', $service?->id) == $item->id)
                                >
                                    {{ $item->titre }}
                                    — {{ number_format($item->prix, 2, ',', ' ') }} DH
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Date --}}
                    <div class="mt-6">

                        <label
                            for="date"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Date souhaitée
                        </label>

                        <input
                            id="date"
                            type="datetime-local"
                            name="date"
                            value="{{ old('date') }}"
                            min="{{ now()->format('Y-m-d\TH:i') }}"
                            required
                            class="w-full rounded-xl border-slate-300 px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500"
                        >

                        <p class="mt-2 text-xs text-slate-400">
                            Choisissez une date et une heure disponibles.
                        </p>

                    </div>


                    {{-- Message --}}
                    <div class="mt-6">

                        <label
                            for="message"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Message
                            <span class="font-normal text-slate-400">
                                (optionnel)
                            </span>
                        </label>

                        <textarea
                            id="message"
                            name="message"
                            rows="5"
                            maxlength="1000"
                            placeholder="Expliquez votre besoin au prestataire..."
                            class="w-full rounded-xl border-slate-300 px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500"
                        >{{ old('message') }}</textarea>

                    </div>


                    {{-- Information --}}
                    <div class="mt-6 rounded-xl bg-indigo-50 p-4">

                        <p class="text-sm leading-6 text-indigo-700">
                            Votre demande sera envoyée au prestataire avec le statut
                            <strong>En attente</strong>.
                        </p>

                    </div>


                    {{-- Buttons --}}
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-end">

                        <a
                            href="{{ $service ? route('services.show', $service) : route('services.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                        >
                            Annuler
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700"
                        >
                            📅 Envoyer la réservation
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>