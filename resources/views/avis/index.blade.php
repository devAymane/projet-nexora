<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-8">

        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

                <div>

                    <div class="mb-3 flex items-center gap-2 text-sm text-slate-500">

                        <a
                            href="{{ route('dashboard') }}"
                            class="transition hover:text-indigo-600"
                        >
                            Dashboard
                        </a>

                        <span>/</span>

                        <span class="text-slate-700">
                            Avis
                        </span>

                    </div>

                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                        Avis
                    </h1>

                    <p class="mt-2 text-sm text-slate-500">
                        Consultez les avis et évaluations des services Nexora.
                    </p>

                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.783.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.363-1.118L4.98 8.719c-.783-.57-.38-1.81.588-1.81H9.03a1 1 0 00.951-.69l1.068-3.292z"
                        />
                    </svg>

                </div>

            </div>


            {{-- Success --}}
            @if(session('success'))

                <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4">

                    <div class="flex items-center gap-3">

                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-green-100 text-green-600">

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
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>

                        </div>

                        <p class="text-sm font-semibold text-green-700">
                            {{ session('success') }}
                        </p>

                    </div>

                </div>

            @endif


            {{-- Error --}}
            @if(session('error'))

                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4">

                    <div class="flex items-center gap-3">

                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-red-100 text-red-600">

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
                                    d="M12 9v4m0 4h.01"
                                />
                            </svg>

                        </div>

                        <p class="text-sm font-semibold text-red-700">
                            {{ session('error') }}
                        </p>

                    </div>

                </div>

            @endif


            {{-- Stats --}}
            <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                    <p class="text-sm font-medium text-slate-500">
                        Total des avis
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ $avis->total() }}
                    </p>

                </div>


                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                    <p class="text-sm font-medium text-slate-500">
                        Note moyenne
                    </p>

                    <div class="mt-2 flex items-center gap-2">

                        @php
                            $average = $avis->count()
                                ? $avis->avg('note')
                                : 0;
                        @endphp

                        <span class="text-3xl font-bold text-slate-900">
                            {{ number_format($average, 1, ',', ' ') }}
                        </span>

                        <span class="text-lg text-yellow-500">
                            ★
                        </span>

                    </div>

                </div>


                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                    <p class="text-sm font-medium text-slate-500">
                        Qualité
                    </p>

                    <p class="mt-2 text-lg font-bold text-green-600">
                        Avis clients
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Évaluations après réservation terminée
                    </p>

                </div>

            </div>


            {{-- Reviews --}}
            @if($avis->count())

                <div class="space-y-4">

                    @foreach($avis as $review)

                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md">

                            <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">

                                {{-- User --}}
                                <div class="flex items-start gap-4">

                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-lg font-bold text-indigo-700">

                                        {{ strtoupper(substr($review->user?->prenom ?? 'U', 0, 1)) }}

                                    </div>

                                    <div>

                                        <h2 class="font-bold text-slate-900">

                                            {{ $review->user?->prenom }}

                                            {{ $review->user?->nom }}

                                        </h2>

                                        <p class="mt-1 text-xs text-slate-400">

                                            {{ $review->date?->format('d/m/Y') }}

                                        </p>

                                    </div>

                                </div>


                                {{-- Rating --}}
                                <div class="flex items-center gap-1">

                                    @for($i = 1; $i <= 5; $i++)

                                        <span
                                            class="text-lg {{ $i <= $review->note ? 'text-yellow-400' : 'text-slate-200' }}"
                                        >
                                            ★
                                        </span>

                                    @endfor

                                    <span class="ml-2 text-sm font-semibold text-slate-600">
                                        {{ $review->note }}/5
                                    </span>

                                </div>

                            </div>


                            {{-- Service --}}
                            @if($review->service)

                                <div class="mt-5 rounded-xl bg-slate-50 p-4">

                                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                        Service évalué
                                    </p>

                                    <div class="mt-1 flex items-center justify-between gap-4">

                                        <p class="font-semibold text-slate-900">
                                            {{ $review->service->titre }}
                                        </p>

                                        <a
                                            href="{{ route('services.show', $review->service) }}"
                                            class="text-sm font-semibold text-indigo-600 hover:text-indigo-700"
                                        >
                                            Voir
                                        </a>

                                    </div>

                                </div>

                            @endif


                            {{-- Comment --}}
                            @if($review->commentaire)

                                <div class="mt-5">

                                    <p class="text-sm leading-7 text-slate-600">
                                        "{{ $review->commentaire }}"
                                    </p>

                                </div>

                            @else

                                <p class="mt-5 text-sm italic text-slate-400">
                                    Aucun commentaire.
                                </p>

                            @endif

                        </div>

                    @endforeach

                </div>


                {{-- Pagination --}}
                @if($avis->hasPages())

                    <div class="mt-8">
                        {{ $avis->links() }}
                    </div>

                @endif

            @else

                {{-- Empty --}}
                <div class="rounded-2xl border border-slate-200 bg-white px-6 py-16 text-center shadow-sm">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">

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
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.783.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.363-1.118L4.98 8.719c-.783-.57-.38-1.81.588-1.81H9.03a1 1 0 00.951-.69l1.068-3.292z"
                            />
                        </svg>

                    </div>

                    <h2 class="mt-5 text-xl font-bold text-slate-900">
                        Aucun avis
                    </h2>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                        Les avis apparaîtront ici après les réservations terminées.
                    </p>

                    <a
                        href="{{ route('services.index') }}"
                        class="mt-6 inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700"
                    >
                        Découvrir les services
                    </a>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>