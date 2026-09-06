<x-app-layout>
    <div class="min-h-screen bg-slate-50 py-6 sm:py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            @php
                $otherUser = auth()->id() === $conversation->client_id
                    ? $conversation->provider
                    : $conversation->client;

                $initials = strtoupper(
                    substr($otherUser->prenom ?? '', 0, 1) .
                    substr($otherUser->nom ?? '', 0, 1)
                );
            @endphp

            {{-- Back --}}
            <div class="mb-4">
                <a
                    href="{{ route('conversations.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-indigo-600"
                >
                    <span>←</span>
                    Retour aux conversations
                </a>
            </div>

            {{-- Chat container --}}
            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                {{-- Chat header --}}
                <div class="border-b border-slate-200 bg-white px-5 py-4 sm:px-6">
                    <div class="flex items-center justify-between gap-4">

                        <div class="flex min-w-0 items-center gap-4">

                            {{-- Avatar --}}
                            <div class="relative shrink-0">
                                @if($otherUser->photo)
                                    <img
                                        src="{{ asset('storage/' . $otherUser->photo) }}"
                                        alt="{{ $otherUser->prenom }} {{ $otherUser->nom }}"
                                        class="h-12 w-12 rounded-full object-cover ring-4 ring-indigo-50"
                                    >
                                @else
                                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 font-bold text-indigo-600 ring-4 ring-indigo-50">
                                        {{ $initials ?: '?' }}
                                    </div>
                                @endif

                                <span class="absolute bottom-0 right-0 h-3.5 w-3.5 rounded-full border-2 border-white bg-green-500"></span>
                            </div>

                            {{-- User info --}}
                            <div class="min-w-0">
                                <h1 class="truncate text-base font-bold text-slate-900 sm:text-lg">
                                    {{ $otherUser->prenom }} {{ $otherUser->nom }}
                                </h1>

                                <p class="text-xs font-medium text-indigo-600 sm:text-sm">
                                    {{ $otherUser->hasRole('provider') ? 'Prestataire' : 'Client' }}
                                </p>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="hidden items-center gap-2 text-xs text-slate-400 sm:flex">
                            <span class="h-2 w-2 rounded-full bg-green-500"></span>
                            Conversation
                        </div>

                    </div>
                </div>

                {{-- Messages --}}
                <div
                    id="messages-container"
                    class="max-h-[600px] min-h-[420px] space-y-5 overflow-y-auto bg-slate-50/70 p-4 sm:p-6"
                >

                    @forelse($conversation->messages as $message)

                        @if($message->user_id === auth()->id())

                            {{-- My message --}}
                            <div class="flex justify-end">
                                <div class="flex max-w-[85%] flex-col items-end sm:max-w-[70%]">

                                    <div class="rounded-2xl rounded-br-md bg-indigo-600 px-4 py-3 text-white shadow-sm">
                                        <p class="whitespace-pre-line break-words text-sm leading-6">
                                            {{ $message->contenu }}
                                        </p>
                                    </div>

                                    <div class="mt-1 flex items-center gap-2 text-[11px] text-slate-400">
                                        <span>
                                            {{ $message->date_envoi?->format('d/m/Y H:i') }}
                                        </span>

                                        @if($message->lu)
                                            <span class="font-medium text-indigo-500">
                                                ✓✓
                                            </span>
                                        @else
                                            <span>
                                                ✓
                                            </span>
                                        @endif
                                    </div>

                                </div>
                            </div>

                        @else

                            {{-- Other user's message --}}
                            <div class="flex justify-start">
                                <div class="flex max-w-[85%] flex-col items-start sm:max-w-[70%]">

                                    <div class="rounded-2xl rounded-bl-md bg-white px-4 py-3 text-slate-800 shadow-sm ring-1 ring-slate-200">
                                        <p class="whitespace-pre-line break-words text-sm leading-6">
                                            {{ $message->contenu }}
                                        </p>
                                    </div>

                                    <span class="mt-1 text-[11px] text-slate-400">
                                        {{ $message->date_envoi?->format('d/m/Y H:i') }}
                                    </span>

                                </div>
                            </div>

                        @endif

                    @empty

                        {{-- Empty chat --}}
                        <div class="flex min-h-[380px] flex-col items-center justify-center px-6 text-center">

                            <div class="flex h-20 w-20 items-center justify-center rounded-3xl bg-indigo-50 text-4xl">
                                💬
                            </div>

                            <h2 class="mt-5 text-lg font-bold text-slate-900">
                                Aucun message
                            </h2>

                            <p class="mt-2 max-w-sm text-sm leading-6 text-slate-500">
                                Commencez la conversation avec
                                {{ $otherUser->prenom }}.
                            </p>

                        </div>

                    @endforelse

                </div>

                {{-- Composer --}}
                <div class="border-t border-slate-200 bg-white p-4 sm:p-5">

                    {{-- Success --}}
                    @if(session('success'))
                        <div class="mb-4 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 p-3 text-sm text-green-700">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-green-100">
                                ✓
                            </span>

                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    {{-- Errors --}}
                    @if($errors->any())
                        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form
                        method="POST"
                        action="{{ route('messages.store', $conversation) }}"
                        class="flex items-end gap-3"
                    >
                        @csrf

                        <div class="flex-1">
                            <label for="contenu" class="sr-only">
                                Votre message
                            </label>

                            <textarea
                                id="contenu"
                                name="contenu"
                                rows="2"
                                required
                                maxlength="2000"
                                placeholder="Écrire un message..."
                                class="block w-full resize-none rounded-2xl border-slate-300 bg-slate-50 text-sm shadow-sm transition placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500"
                            >{{ old('contenu') }}</textarea>

                            <div class="mt-1 text-[11px] text-slate-400">
                                Maximum 2000 caractères
                            </div>
                        </div>

                        <button
                            type="submit"
                            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-2xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            <span>Envoyer</span>
                            <span class="text-base">➤</span>
                        </button>
                    </form>

                </div>

            </div>

            {{-- Security/info --}}
            <div class="mt-4 flex items-center justify-center gap-2 text-xs text-slate-400">
                <span>🔒</span>
                Vos échanges restent privés entre les participants.
            </div>

        </div>
    </div>

    {{-- Scroll to latest message --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('messages-container');

            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        });
    </script>
</x-app-layout>