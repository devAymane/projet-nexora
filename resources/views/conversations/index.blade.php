<x-app-layout>
    <div class="min-h-screen bg-slate-50 py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <div class="mb-2 flex items-center gap-2 text-sm text-slate-500">
                        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600">
                            Dashboard
                        </a>
                        <span>/</span>
                        <span>Messages</span>
                    </div>

                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                        Mes conversations
                    </h1>

                    <p class="mt-2 text-sm text-slate-500">
                        Retrouvez vos échanges avec les clients et prestataires.
                    </p>
                </div>

                <div class="inline-flex w-fit items-center gap-2 rounded-xl bg-indigo-50 px-4 py-2 text-sm font-medium text-indigo-700">
                    <span class="text-lg">💬</span>
                    {{ $conversations->total() }} conversation{{ $conversations->total() > 1 ? 's' : '' }}
                </div>
            </div>

            {{-- Success message --}}
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 rounded-2xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100">
                        ✓
                    </span>

                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- Conversations --}}
            @if($conversations->count())

                <div class="space-y-3">
                    @foreach($conversations as $conversation)

                        @php
                            $otherUser = auth()->id() === $conversation->client_id
                                ? $conversation->provider
                                : $conversation->client;

                            $lastMessage = $conversation->messages->first();

                            $initials = strtoupper(
                                substr($otherUser->prenom ?? '', 0, 1) .
                                substr($otherUser->nom ?? '', 0, 1)
                            );
                        @endphp

                        <a
                            href="{{ route('conversations.show', $conversation) }}"
                            class="group block rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-indigo-300 hover:shadow-lg"
                        >
                            <div class="flex items-center gap-4">

                                {{-- Avatar --}}
                                <div class="relative shrink-0">
                                    @if($otherUser->photo)
                                        <img
                                            src="{{ asset('storage/' . $otherUser->photo) }}"
                                            alt="{{ $otherUser->prenom }} {{ $otherUser->nom }}"
                                            class="h-14 w-14 rounded-full object-cover ring-4 ring-indigo-50"
                                        >
                                    @else
                                        <div class="flex h-14 w-14 items-center justify-center rounded-full bg-indigo-100 text-lg font-bold text-indigo-600 ring-4 ring-indigo-50">
                                            {{ $initials ?: '?' }}
                                        </div>
                                    @endif

                                    <span class="absolute bottom-0 right-0 h-3.5 w-3.5 rounded-full border-2 border-white bg-green-500"></span>
                                </div>

                                {{-- User + message --}}
                                <div class="min-w-0 flex-1">

                                    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                                        <div class="min-w-0">
                                            <h2 class="truncate font-semibold text-slate-900 group-hover:text-indigo-600">
                                                {{ $otherUser->prenom }} {{ $otherUser->nom }}
                                            </h2>

                                            <p class="text-xs font-medium text-indigo-600">
                                                {{ $otherUser->hasRole('provider') ? 'Prestataire' : 'Client' }}
                                            </p>
                                        </div>

                                        <span class="shrink-0 text-xs text-slate-400">
                                            {{ $conversation->updated_at?->format('d/m/Y H:i') }}
                                        </span>
                                    </div>

                                    @if($lastMessage)
                                        <p class="mt-2 truncate text-sm text-slate-500">
                                            {{ Str::limit($lastMessage->contenu, 100) }}
                                        </p>
                                    @else
                                        <p class="mt-2 text-sm italic text-slate-400">
                                            Aucun message pour le moment.
                                        </p>
                                    @endif
                                </div>

                                {{-- Arrow --}}
                                <div class="hidden shrink-0 text-slate-300 transition group-hover:translate-x-1 group-hover:text-indigo-500 sm:block">
                                    →
                                </div>
                            </div>
                        </a>

                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($conversations->hasPages())
                    <div class="mt-8">
                        {{ $conversations->links() }}
                    </div>
                @endif

            @else

                {{-- Empty state --}}
                <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                    <div class="px-6 py-16 text-center sm:px-12">

                        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-indigo-50 text-4xl">
                            💬
                        </div>

                        <h2 class="mt-6 text-xl font-bold text-slate-900">
                            Aucune conversation
                        </h2>

                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                            Vous n'avez pas encore de conversation.
                            Commencez à échanger avec un client ou un prestataire
                            depuis une prestation.
                        </p>

                        <a
                            href="{{ route('services.index') }}"
                            class="mt-6 inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700"
                        >
                            Découvrir les services
                        </a>
                    </div>
                </div>

            @endif

        </div>
    </div>
</x-app-layout>