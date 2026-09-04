<x-app-layout>
    <div class="min-h-screen bg-slate-50 py-8">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            {{-- Retour --}}
            <div class="mb-6">
                <a
                    href="{{ route('services.index') }}"
                    class="text-sm font-medium text-indigo-600 hover:text-indigo-700"
                >
                    ← Retour aux services
                </a>
            </div>

            {{-- Service --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="grid lg:grid-cols-2">

                    {{-- Image --}}
                    <div class="min-h-[350px] bg-slate-100">

                        @if($service->image)
                            <img
                                src="{{ asset('storage/' . $service->image) }}"
                                alt="{{ $service->titre }}"
                                class="h-full min-h-[350px] w-full object-cover"
                            >
                        @else
                            <div class="flex h-full min-h-[350px] items-center justify-center text-slate-400">
                                <span>
                                    Aucune image disponible
                                </span>
                            </div>
                        @endif

                    </div>

                    {{-- Informations --}}
                    <div class="p-6 sm:p-8">

                        {{-- Category --}}
                        <span class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-600">
                            {{ $service->category->nom }}
                        </span>

                        {{-- Title --}}
                        <h1 class="mt-4 text-3xl font-bold text-slate-900">
                            {{ $service->titre }}
                        </h1>

                        {{-- Price --}}
                        <div class="mt-5">
                            <span class="text-3xl font-bold text-indigo-600">
                                {{ number_format($service->prix, 2, ',', ' ') }} DH
                            </span>
                        </div>

                        {{-- Availability --}}
                        <div class="mt-4">
                            @if($service->disponibilite)
                                <span class="inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-sm font-medium text-green-700">
                                    ● Disponible
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-sm font-medium text-red-700">
                                    ● Indisponible
                                </span>
                            @endif
                        </div>

                        {{-- Description --}}
                        <div class="mt-8">
                            <h2 class="text-lg font-semibold text-slate-900">
                                Description
                            </h2>

                            <p class="mt-3 whitespace-pre-line text-sm leading-7 text-slate-600">
                                {{ $service->description }}
                            </p>
                        </div>

                        {{-- Location --}}
                        <div class="mt-6">
                            <p class="text-sm text-slate-500">
                                📍 Ville
                            </p>

                            <p class="mt-1 font-medium text-slate-800">
                                {{ $service->ville }}
                            </p>
                        </div>

                        {{-- Provider --}}
                        <div class="mt-6 border-t border-slate-200 pt-6">
                            <p class="text-sm text-slate-500">
                                Prestataire
                            </p>

                            <p class="mt-1 font-semibold text-slate-900">
                                {{ $service->user->prenom }}
                                {{ $service->user->nom }}
                            </p>

                            @if($service->user->ville)
                                <p class="mt-1 text-sm text-slate-500">
                                    📍 {{ $service->user->ville }}
                                </p>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="mt-8 flex flex-col gap-3 sm:flex-row">

                            @auth
                                @if(auth()->id() !== $service->user_id)
                                    <a
                                        href="#"
                                        class="inline-flex flex-1 items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700"
                                    >
                                        Réserver ce service
                                    </a>
                                @endif
                            @endauth

                            @auth
                                @if(auth()->id() === $service->user_id)
                                    <a
                                        href="{{ route('services.edit', $service) }}"
                                        class="inline-flex flex-1 items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700"
                                    >
                                        Modifier
                                    </a>
                                @endif
                            @endauth

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>