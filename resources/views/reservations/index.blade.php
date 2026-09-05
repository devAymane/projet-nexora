<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="text-xl font-semibold text-gray-800">
                Mes conversations
            </h2>

            <p class="text-sm text-gray-500">
                Consultez vos conversations avec les clients et prestataires.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 rounded-lg bg-green-50 p-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if ($conversations->count())

                <div class="overflow-hidden rounded-xl bg-white shadow-sm">

                    <div class="divide-y divide-gray-200">

                        @foreach ($conversations as $conversation)

                            @php
                                $user = auth()->id() === $conversation->client_id
                                    ? $conversation->provider
                                    : $conversation->client;

                                $lastMessage = $conversation->messages->first();
                            @endphp

                            <a href="{{ route('conversations.show', $conversation) }}"
                               class="block p-5 transition hover:bg-gray-50">

                                <div class="flex items-center gap-4">

                                    {{-- Avatar --}}
                                    @if ($user->photo)
                                        <img src="{{ asset('storage/' . $user->photo) }}"
                                             alt="{{ $user->prenom }}"
                                             class="h-12 w-12 shrink-0 rounded-full object-cover">
                                    @else
                                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-indigo-100 font-semibold text-indigo-700">
                                            {{ strtoupper(substr($user->prenom, 0, 1)) }}
                                        </div>
                                    @endif

                                    {{-- Conversation --}}
                                    <div class="min-w-0 flex-1">

                                        <div class="flex items-center justify-between gap-3">

                                            <h3 class="font-semibold text-gray-900">
                                                {{ $user->prenom }}
                                                {{ $user->nom }}
                                            </h3>

                                            @if ($lastMessage)
                                                <span class="shrink-0 text-xs text-gray-400">
                                                    {{ $lastMessage->date_envoi->format('d/m/Y H:i') }}
                                                </span>
                                            @endif

                                        </div>

                                        <p class="mt-1 text-sm text-gray-500">
                                            {{ $user->hasRole('provider') ? 'Prestataire' : 'Client' }}
                                        </p>

                                        @if ($lastMessage)

                                            <p class="mt-2 truncate text-sm text-gray-600">
                                                {{ $lastMessage->user_id === auth()->id() ? 'Vous : ' : '' }}
                                                {{ $lastMessage->contenu }}
                                            </p>

                                        @else

                                            <p class="mt-2 text-sm italic text-gray-400">
                                                Aucun message pour le moment.
                                            </p>

                                        @endif

                                    </div>

                                    <span class="text-gray-400">
                                        →
                                    </span>

                                </div>

                            </a>

                        @endforeach

                    </div>

                </div>

                <div class="mt-6">
                    {{ $conversations->links() }}
                </div>

            @else

                <div class="rounded-xl bg-white p-12 text-center shadow-sm">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                        <span class="text-3xl">💬</span>
                    </div>

                    <h3 class="mt-5 text-lg font-semibold text-gray-900">
                        Aucune conversation
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Vous n'avez pas encore de conversation.
                    </p>

                    <a href="{{ route('services.index') }}"
                       class="mt-6 inline-flex rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-indigo-700">
                        Explorer les services
                    </a>

                </div>

            @endif

        </div>
    </div>

</x-app-layout>