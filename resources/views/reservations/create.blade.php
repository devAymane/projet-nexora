<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-8">

        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            {{-- =====================================================
                BREADCRUMB
            ====================================================== --}}
            <div class="mb-6 flex items-center gap-2 text-sm text-slate-500">

                <a
                    href="{{ route('reservations.index') }}"
                    class="transition hover:text-indigo-600"
                >
                    Réservations
                </a>

                <span>/</span>

                <span class="text-slate-700">
                    Nouvelle réservation
                </span>

            </div>


            {{-- =====================================================
                HEADER
            ====================================================== --}}
            <div class="mb-8">

                <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                    Nouvelle réservation
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    Choisissez un service et envoyez votre demande au prestataire.
                </p>

            </div>


            {{-- =====================================================
                VALIDATION ERRORS
            ====================================================== --}}
            @if($errors->any())

                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5">

                    <div class="flex items-start gap-3">

                        <div class="mt-0.5 text-red-600">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 9v4m0 4h.01M10.29 3.86l-7.82 13.5A2 2 0 004.2 20.36h15.6a2 2 0 001.73-3L13.71 3.86a2 2 0 00-3.42 0z"
                                />
                            </svg>

                        </div>

                        <div>

                            <p class="font-semibold text-red-800">
                                Vérifiez les informations saisies.
                            </p>

                            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">

                                @foreach($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    </div>

                </div>

            @endif


            {{-- =====================================================
                MAIN GRID
            ====================================================== --}}
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">


                {{-- =================================================
                    FORM
                ================================================== --}}
                <div class="lg:col-span-2">

                    <form
                        action="{{ route('reservations.store') }}"
                        method="POST"
                        class="space-y-6"
                    >

                        @csrf


                        {{-- =========================================
                            SERVICE
                        ========================================== --}}
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                            <div class="mb-6">

                                <h2 class="text-lg font-bold text-slate-900">
                                    1. Choisissez un service
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    Sélectionnez le service que vous souhaitez réserver.
                                </p>

                            </div>


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
                                class="w-full rounded-xl border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-indigo-500 focus:ring-indigo-500"
                            >

                                <option value="">
                                    Sélectionnez un service
                                </option>


                                @foreach($services as $item)

                                    <option
                                        value="{{ $item->id }}"
                                        @selected(
                                            old('service_id', $service?->id) == $item->id
                                        )
                                    >
                                        {{ $item->titre }}
                                        — {{ number_format($item->prix, 2, ',', ' ') }} DH
                                    </option>

                                @endforeach

                            </select>


                            @error('service_id')

                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- =========================================
                            DATE
                        ========================================== --}}
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                            <div class="mb-6">

                                <h2 class="text-lg font-bold text-slate-900">
                                    2. Date de réservation
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    Choisissez la date et l'heure souhaitées.
                                </p>

                            </div>


                            <label
                                for="date"
                                class="mb-2 block text-sm font-semibold text-slate-700"
                            >
                                Date et heure
                            </label>


                            <input
                                id="date"
                                name="date"
                                type="datetime-local"
                                value="{{ old('date') }}"
                                required
                                class="w-full rounded-xl border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-indigo-500 focus:ring-indigo-500"
                            />


                            @error('date')

                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror


                            <div class="mt-3 flex items-start gap-2 text-xs text-slate-400">

                                <svg
                                    class="mt-0.5 h-4 w-4 shrink-0"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>

                                <span>
                                    Le prestataire recevra votre demande avec la date choisie.
                                </span>

                            </div>

                        </div>


                        {{-- =========================================
                            MESSAGE
                        ========================================== --}}
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                            <div class="mb-6">

                                <h2 class="text-lg font-bold text-slate-900">
                                    3. Votre message
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    Ajoutez des détails ou précisions pour le prestataire.
                                </p>

                            </div>


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
                                rows="6"
                                maxlength="2000"
                                placeholder="Bonjour, je souhaite réserver ce service parce que..."
                                class="w-full resize-none rounded-xl border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-indigo-500"
                            >{{ old('message') }}</textarea>


                            @error('message')

                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror


                            <p class="mt-2 text-right text-xs text-slate-400">
                                Maximum 2000 caractères
                            </p>

                        </div>


                        {{-- =========================================
                            SUBMIT
                        ========================================== --}}
                        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                            <a
                                href="{{ route('reservations.index') }}"
                                class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                            >
                                Annuler
                            </a>


                            <button
                                type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700"
                            >

                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>

                                Envoyer la réservation

                            </button>

                        </div>

                    </form>

                </div>


                {{-- =================================================
                    SERVICE SUMMARY
                ================================================== --}}
                <div class="lg:col-span-1">

                    <div class="sticky top-24 space-y-5">


                        {{-- =========================================
                            SELECTED SERVICE
                        ========================================== --}}
                        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                            @if($service)

                                {{-- Image --}}
                                <div class="relative h-48 overflow-hidden bg-slate-100">

                                    @if($service->image)

                                        <img
                                            src="{{ asset('storage/' . $service->image) }}"
                                            alt="{{ $service->titre }}"
                                            class="h-full w-full object-cover"
                                        >

                                    @else

                                        <div class="flex h-full items-center justify-center bg-gradient-to-br from-indigo-50 to-slate-100">

                                            <svg
                                                class="h-14 w-14 text-indigo-200"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 16m-8-9h.01M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"
                                                />
                                            </svg>

                                        </div>

                                    @endif

                                </div>


                                <div class="p-5">

                                    {{-- Category --}}
                                    @if($service->category)

                                        <span class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700">
                                            {{ $service->category->nom }}
                                        </span>

                                    @endif


                                    {{-- Title --}}
                                    <h2 class="mt-3 text-xl font-bold text-slate-900">
                                        {{ $service->titre }}
                                    </h2>


                                    {{-- Provider --}}
                                    <div class="mt-4 flex items-center gap-3">

                                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700">

                                            {{ strtoupper(substr($service->user?->prenom ?? 'P', 0, 1)) }}

                                        </div>


                                        <div>

                                            <p class="text-sm font-semibold text-slate-800">
                                                {{ $service->user?->prenom }}
                                                {{ $service->user?->nom }}
                                            </p>

                                            @if($service->ville)

                                                <p class="text-xs text-slate-400">
                                                    {{ $service->ville }}
                                                </p>

                                            @endif

                                        </div>

                                    </div>


                                    {{-- Price --}}
                                    <div class="mt-5 border-t border-slate-100 pt-5">

                                        <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                            Prix du service
                                        </p>

                                        <div class="mt-1 flex items-baseline gap-1">

                                            <span class="text-3xl font-bold text-slate-900">
                                                {{ number_format($service->prix, 2, ',', ' ') }}
                                            </span>

                                            <span class="text-sm font-medium text-slate-500">
                                                DH
                                            </span>

                                        </div>

                                    </div>

                                </div>

                            @else

                                {{-- No selected service --}}
                                <div class="p-6 text-center">

                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">

                                        <svg
                                            class="h-7 w-7"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.8"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z"
                                            />
                                        </svg>

                                    </div>

                                    <h2 class="mt-4 font-bold text-slate-900">
                                        Aucun service sélectionné
                                    </h2>

                                    <p class="mt-2 text-sm text-slate-500">
                                        Sélectionnez un service dans le formulaire.
                                    </p>

                                </div>

                            @endif

                        </div>


                        {{-- =========================================
                            INFORMATION
                        ========================================== --}}
                        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                            <h3 class="font-bold text-slate-900">
                                Comment ça marche ?
                            </h3>


                            <div class="mt-5 space-y-5">


                                <div class="flex gap-3">

                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-sm font-bold text-indigo-600">
                                        1
                                    </div>

                                    <div>

                                        <p class="text-sm font-semibold text-slate-800">
                                            Envoyez votre demande
                                        </p>

                                        <p class="mt-1 text-xs leading-5 text-slate-500">
                                            Choisissez votre service et la date souhaitée.
                                        </p>

                                    </div>

                                </div>


                                <div class="flex gap-3">

                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-sm font-bold text-indigo-600">
                                        2
                                    </div>

                                    <div>

                                        <p class="text-sm font-semibold text-slate-800">
                                            Le prestataire répond
                                        </p>

                                        <p class="mt-1 text-xs leading-5 text-slate-500">
                                            Votre réservation reste en attente jusqu'à sa réponse.
                                        </p>

                                    </div>

                                </div>


                                <div class="flex gap-3">

                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-sm font-bold text-indigo-600">
                                        3
                                    </div>

                                    <div>

                                        <p class="text-sm font-semibold text-slate-800">
                                            Réservation confirmée
                                        </p>

                                        <p class="mt-1 text-xs leading-5 text-slate-500">
                                            Une fois acceptée, vous pourrez suivre votre réservation.
                                        </p>

                                    </div>

                                </div>


                            </div>

                        </div>


                        {{-- =========================================
                            TRUST
                        ========================================== --}}
                        <div class="rounded-2xl bg-indigo-600 p-5 text-white shadow-sm">

                            <div class="flex items-start gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/10">

                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4z"
                                        />
                                    </svg>

                                </div>

                                <div>

                                    <p class="font-semibold">
                                        Réservation sécurisée
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-indigo-100">
                                        Vos informations sont protégées et votre demande est envoyée directement au prestataire.
                                    </p>

                                </div>

                            </div>

                        </div>


                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>