<x-app-layout>
    <div class="min-h-screen bg-slate-50 py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

            {{-- Back --}}
            <div class="mb-6">
                <a
                    href="{{ url()->previous() }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-indigo-600"
                >
                    <span>←</span>
                    Retour
                </a>
            </div>

            {{-- Header --}}
            <div class="mb-6">
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                    Nouvelle conversation
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    Commencez une discussion avec ce membre de Nexora.
                </p>
            </div>

            {{-- User card --}}
            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 bg-gradient-to-r from-indigo-50 to-white p-6">
                    <div class="flex items-center gap-4">

                        {{-- Avatar --}}
                        @php
                            $initials = strtoupper(
                                substr($user->prenom ?? '', 0, 1) .
                                substr($user->nom ?? '', 0, 1)
                            );
                        @endphp

                        @if($user->photo)
                            <img
                                src="{{ asset('storage/' . $user->photo) }}"
                                alt="{{ $user->prenom }} {{ $user->nom }}"
                                class="h-16 w-16 rounded-full object-cover ring-4 ring-white shadow-sm"
                            >
                        @else
                            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-indigo-600 text-lg font-bold text-white ring-4 ring-white shadow-sm">
                                {{ $initials ?: '?' }}
                            </div>
                        @endif

                        <div>
                            <h2 class="text-lg font-bold text-slate-900">
                                {{ $user->prenom }} {{ $user->nom }}
                            </h2>

                            <p class="mt-1 text-sm font-medium text-indigo-600">
                                {{ $user->hasRole('provider') ? 'Prestataire' : 'Client' }}
                            </p>

                            @if($user->ville)
                                <p class="mt-1 text-xs text-slate-500">
                                    📍 {{ $user->ville }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Form --}}
                <div class="p-6 sm:p-8">

                    @if($errors->any())
                        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form
                        method="POST"
                        action="{{ route('conversations.create', $user) }}"
                        class="space-y-6"
                    >
                        @csrf

                        <div>
                            <label
                                for="contenu"
                                class="mb-2 block text-sm font-semibold text-slate-700"
                            >
                                Votre message
                            </label>

                            <textarea
                                id="contenu"
                                name="contenu"
                                rows="6"
                                maxlength="2000"
                                required
                                placeholder="Écrivez votre message..."
                                class="block w-full resize-none rounded-2xl border-slate-300 bg-slate-50 text-sm shadow-sm transition placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500"
                            >{{ old('contenu') }}</textarea>

                            <div class="mt-2 flex justify-between text-xs text-slate-400">
                                <span>
                                    Présentez votre demande clairement.
                                </span>

                                <span>
                                    Maximum 2000 caractères
                                </span>
                            </div>
                        </div>

                        {{-- Info --}}
                        <div class="rounded-2xl border border-indigo-100 bg-indigo-50 p-4">
                            <div class="flex gap-3">
                                <span class="text-lg">💡</span>

                                <div>
                                    <p class="text-sm font-semibold text-indigo-900">
                                        Conseil
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-indigo-700">
                                        Évitez de partager des informations sensibles
                                        et expliquez clairement votre besoin.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">

                            <a
                                href="{{ url()->previous() }}"
                                class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                            >
                                Annuler
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            >
                                <span>Envoyer le message</span>
                                <span>➤</span>
                            </button>

                        </div>

                    </form>
                </div>
            </div>

            {{-- Privacy --}}
            <div class="mt-4 flex items-center justify-center gap-2 text-xs text-slate-400">
                <span>🔒</span>
                Vos échanges restent privés entre les participants.
            </div>

        </div>
    </div>
</x-app-layout>