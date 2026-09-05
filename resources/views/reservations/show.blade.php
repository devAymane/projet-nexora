<x-app-layout>

    @php
        $otherUser = auth()->id() === $conversation->client_id
            ? $conversation->provider
            : $conversation->client;
    @endphp

    <x-slot name="header">
        <div class="flex items-center gap-3">

            <a href="{{ route('conversations.index') }}"
               class="text-gray-500 hover:text-gray-900">
                ←
            </a>

            @if ($otherUser->photo)
                <img src="{{ asset('storage/' . $otherUser->photo) }}"
                     alt="{{ $otherUser->prenom }}"
                     class="h-10 w-10 rounded-full object-cover">
            @else
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 font-semibold text-indigo-700">
                    {{ strtoupper(substr($otherUser->prenom, 0, 1)) }}
                </div>
            @endif

            <div>
                <h2 class="font-semibold text-gray-800">
                    {{ $otherUser->prenom }}
                    {{ $otherUser->nom }}
                </h2>

                <p class="text-xs text-gray-500">
                    {{ $otherUser->hasRole('provider') ? 'Prestataire' : 'Client' }}
                </p>
            </div>

        </div>
    </x-slot>

    <div class="py-8">

        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            <div class="flex h-[650px] flex-col overflow-hidden rounded-xl bg-white shadow-sm">

                {{-- Chat header --}}
                <div class="border-b border-gray-200 px-6 py-4">

                    <h3 class="font-semibold text-gray-900">
                        Conversation
                    </h3>

                    <p class="text-sm text-gray-500">
                        Échangez directement avec {{ $otherUser->prenom }}.
                    </p>

                </div>

                {{-- Messages --}}
                <div id="messages"
                     class="flex-1 space-y-4 overflow-y-auto bg-gray-50 p-6">

                    @forelse ($conversation->messages as $message)

                        @php
                            $isMine = $message->user_id === auth()->id();
                        @endphp

                        <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">

                            <div class="max-w-[80%]">

                                <div class="{{ $isMine
                                    ? 'rounded-2xl rounded-br-md bg-indigo-600 text-white'
                                    : 'rounded-2xl rounded-bl-md bg-white text-gray-800 border border-gray-200'
                                }} px-4 py-3 shadow-sm">

                                    <p class="whitespace-pre-wrap text-sm leading-6">
                                        {{ $message->contenu }}
                                    </p>

                                </div>

                                <div class="mt-1 px-1 text-xs text-gray-400 {{ $isMine ? 'text-right' : 'text-left' }}">
                                    {{ $message->date_envoi->format('d/m/Y H:i') }}

                                    @if ($isMine)
                                        · {{ $message->lu ? 'Lu' : 'Envoyé' }}
                                    @endif
                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="flex h-full items-center justify-center text-center">

                            <div>
                                <div class="text-4xl">💬</div>

                                <h3 class="mt-3 font-semibold text-gray-900">
                                    Aucun message
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    Envoyez votre premier message.
                                </p>
                            </div>

                        </div>

                    @endforelse

                </div>

                {{-- Send message --}}
                <div class="border-t border-gray-200 bg-white p-4">

                    @if ($errors->any())
                        <div class="mb-3 rounded-lg bg-red-50 p-3 text-sm text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST"
                          action="{{ route('messages.store', $conversation) }}"
                          class="flex items-end gap-3">

                        @csrf

                        <div class="flex-1">

                            <label for="contenu" class="sr-only">
                                Message
                            </label>

                            <textarea name="contenu"
                                      id="contenu"
                                      rows="2"
                                      required
                                      maxlength="2000"
                                      placeholder="Écrivez votre message..."
                                      class="w-full resize-none rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('contenu') }}</textarea>

                        </div>

                        <button type="submit"
                                class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-700">
                            Envoyer
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>