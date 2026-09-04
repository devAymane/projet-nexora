<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-900">
                    Mes conversations
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    Retrouvez vos échanges avec les clients et prestataires.
                </p>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-xl bg-green-50 p-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if($conversations->count())

                <div class="space-y-4">

                    @foreach($conversations as $conversation)

                        @php
                            $otherUser = auth()->id() === $conversation->client_id
                                ? $conversation->provider
                                : $conversation->client;
                        @endphp

                        <a
                            href="{{ route('conversations.show', $conversation) }}"
                            class="block rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-indigo-300 hover:shadow-md"
                        >

                            <div class="flex items-center justify-between gap-4">

                                <div class="flex items-center gap-4">

                                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 font-bold text-indigo-600">
                                        {{ strtoupper(substr($otherUser->prenom, 0, 1)) }}
                                    </div>

                                    <div>
                                        <h2 class="font-semibold text-slate-900">
                                            {{ $otherUser->prenom }} {{ $otherUser->nom }}
                                        </h2>

                                        <p class="text-sm text-slate-500">
                                            {{ $otherUser->hasRole('provider') ? 'Prestataire' : 'Client' }}
                                        </p>
                                    </div>

                                </div>

                                <div class="text-sm text-slate-400">
                                    {{ $conversation->updated_at?->format('d/m/Y H:i') }}
                                </div>

                            </div>

                            @if($conversation->messages->first())

                                <div class="mt-4 border-t border-slate-100 pt-4">

                                    <p class="text-sm text-slate-600">
                                        {{ Str::limit($conversation->messages->first()->contenu, 120) }}
                                    </p>

                                </div>

                            @else

                                <p class="mt-4 text-sm italic text-slate-400">
                                    Aucun message pour le moment.
                                </p>

                            @endif

                        </a>

                    @endforeach

                </div>

                <div class="mt-8">
                    {{ $conversations->links() }}
                </div>

            @else

                <div class="rounded-2xl border border-slate-200 bg-white p-12 text-center">

                    <div class="text-5xl">💬</div>

                    <h2 class="mt-4 text-xl font-bold text-slate-900">
                        Aucune conversation
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">
                        Vous n'avez pas encore de conversation.
                    </p>

                </div>

            @endif

        </div>
    </div>

</x-app-layout>