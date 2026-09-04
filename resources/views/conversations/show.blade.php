<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-6">

                <a
                    href="{{ route('conversations.index') }}"
                    class="text-sm font-medium text-indigo-600 hover:text-indigo-700"
                >
                    ← Retour aux conversations
                </a>

                @php
                    $otherUser = auth()->id() === $conversation->client_id
                        ? $conversation->provider
                        : $conversation->client;
                @endphp

                <div class="mt-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                    <div class="flex items-center gap-4">

                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 font-bold text-indigo-600">
                            {{ strtoupper(substr($otherUser->prenom, 0, 1)) }}
                        </div>

                        <div>
                            <h1 class="text-xl font-bold text-slate-900">
                                {{ $otherUser->prenom }} {{ $otherUser->nom }}
                            </h1>

                            <p class="text-sm text-slate-500">
                                {{ $otherUser->hasRole('provider') ? 'Prestataire' : 'Client' }}
                            </p>
                        </div>

                    </div>

                </div>

            </div>

            {{-- Messages --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="max-h-[550px] space-y-4 overflow-y-auto p-6">

                    @forelse($conversation->messages as $message)

                        @if($message->user_id === auth()->id())

                            <div class="flex justify-end">

                                <div class="max-w-[80%]">

                                    <div class="rounded-2xl rounded-br-md bg-indigo-600 px-4 py-3 text-white">

                                        <p class="whitespace-pre-line text-sm">
                                            {{ $message->contenu }}
                                        </p>

                                    </div>

                                    <p class="mt-1 text-right text-xs text-slate-400">
                                        {{ $message->date_envoi->format('d/m/Y H:i') }}
                                    </p>

                                </div>

                            </div>

                        @else

                            <div class="flex justify-start">

                                <div class="max-w-[80%]">

                                    <div class="rounded-2xl rounded-bl-md bg-slate-100 px-4 py-3 text-slate-800">

                                        <p class="whitespace-pre-line text-sm">
                                            {{ $message->contenu }}
                                        </p>

                                    </div>

                                    <p class="mt-1 text-xs text-slate-400">
                                        {{ $message->date_envoi->format('d/m/Y H:i') }}
                                    </p>

                                </div>

                            </div>

                        @endif

                    @empty

                        <div class="py-12 text-center">

                            <div class="text-4xl">💬</div>

                            <p class="mt-3 text-sm text-slate-500">
                                Aucun message pour le moment.
                            </p>

                        </div>

                    @endforelse

                </div>

                {{-- Send message --}}
                <div class="border-t border-slate-200 p-5">

                    @if(session('success'))
                        <div class="mb-4 rounded-xl bg-green-50 p-3 text-sm text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 rounded-xl bg-red-50 p-3 text-sm text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form
                        method="POST"
                        action="{{ route('messages.store', $conversation) }}"
                        class="flex gap-3"
                    >
                        @csrf

                        <textarea
                            name="contenu"
                            rows="2"
                            required
                            maxlength="5000"
                            placeholder="Écrire un message..."
                            class="flex-1 resize-none rounded-xl border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >{{ old('contenu') }}</textarea>

                        <button
                            type="submit"
                            class="self-end rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-700"
                        >
                            Envoyer
                        </button>

                    </form>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>