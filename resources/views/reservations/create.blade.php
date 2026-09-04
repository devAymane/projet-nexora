<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">
                Nouvelle réservation
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Choisissez un service et indiquez la date souhaitée.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

            {{-- Erreurs générales --}}
            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-4">
                    <p class="font-semibold text-red-700">
                        Vérifiez les informations saisies.
                    </p>

                    <ul class="mt-2 list-disc pl-5 text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

                <form
                    method="POST"
                    action="{{ route('reservations.store') }}"
                    class="space-y-6"
                >
                    @csrf

                    {{-- Service --}}
                    <div>
                        <label
                            for="service_id"
                            class="block text-sm font-semibold text-slate-700"
                        >
                            Service
                        </label>

                        <select
                            id="service_id"
                            name="service_id"
                            required
                            class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="">
                                -- Sélectionnez un service --
                            </option>

                            @foreach ($services as $service)
                                <option
                                    value="{{ $service->id }}"
                                    @selected(old('service_id') == $service->id)
                                >
                                    {{ $service->titre }}
                                    — {{ number_format($service->prix, 2, ',', ' ') }} DH
                                    — {{ $service->ville }}
                                </option>
                            @endforeach
                        </select>

                        @error('service_id')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Date --}}
                    <div>
                        <label
                            for="date"
                            class="block text-sm font-semibold text-slate-700"
                        >
                            Date et heure
                        </label>

                        <input
                            id="date"
                            name="date"
                            type="datetime-local"
                            value="{{ old('date') }}"
                            min="{{ now()->format('Y-m-d\TH:i') }}"
                            required
                            class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >

                        @error('date')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Message --}}
                    <div>
                        <label
                            for="message"
                            class="block text-sm font-semibold text-slate-700"
                        >
                            Message
                        </label>

                        <textarea
                            id="message"
                            name="message"
                            rows="5"
                            maxlength="1000"
                            placeholder="Ajoutez un message ou des détails concernant votre demande..."
                            class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >{{ old('message') }}</textarea>

                        <p class="mt-1 text-xs text-slate-500">
                            Maximum 1000 caractères.
                        </p>

                        @error('message')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Informations --}}
                    <div class="rounded-xl border border-indigo-100 bg-indigo-50 p-4">
                        <p class="text-sm font-semibold text-indigo-800">
                            À savoir
                        </p>

                        <p class="mt-1 text-sm text-indigo-700">
                            Votre réservation sera envoyée avec le statut
                            <strong>En attente</strong>.
                            Le prestataire devra ensuite l'accepter ou la refuser.
                        </p>
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('reservations.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                        >
                            Annuler
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700"
                        >
                            Confirmer la réservation
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>