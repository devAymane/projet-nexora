<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="text-xl font-semibold text-gray-800">
                Notifications
            </h2>

            <p class="text-sm text-gray-500">
                Retrouvez toutes vos notifications.
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

            @if ($notifications->count())

                <div class="mb-4 flex justify-end">
                    @if (auth()->user()->unreadNotifications->count())
                        <form method="POST"
                              action="{{ route('notifications.read-all') }}">
                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                Tout marquer comme lu
                            </button>
                        </form>
                    @endif
                </div>

                <div class="overflow-hidden rounded-xl bg-white shadow-sm">

                    <div class="divide-y divide-gray-200">

                        @foreach ($notifications as $notification)

                            @php
                                $data = $notification->data;
                                $type = $data['type'] ?? 'notification';
                                $message = $data['message'] ?? 'Vous avez une nouvelle notification.';
                            @endphp

                            <div class="{{ $notification->read_at ? 'bg-white' : 'bg-indigo-50/50' }} p-5">

                                <div class="flex items-start gap-4">

                                    {{-- Icon --}}
                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full
                                        {{ $notification->read_at ? 'bg-gray-100' : 'bg-indigo-100' }}">

                                        @if ($type === 'new_message')
                                            <span class="text-xl">💬</span>

                                        @elseif ($type === 'reservation_created')
                                            <span class="text-xl">📅</span>

                                        @elseif ($type === 'reservation_accepted')
                                            <span class="text-xl">✅</span>

                                        @elseif ($type === 'reservation_refused')
                                            <span class="text-xl">❌</span>

                                        @elseif ($type === 'reservation_completed')
                                            <span class="text-xl">🎉</span>

                                        @else
                                            <span class="text-xl">🔔</span>
                                        @endif

                                    </div>

                                    {{-- Content --}}
                                    <div class="min-w-0 flex-1">

                                        <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">

                                            <div>

                                                @if ($type === 'new_message')
                                                    <h3 class="font-semibold text-gray-900">
                                                        Nouveau message
                                                    </h3>

                                                @elseif ($type === 'reservation_created')
                                                    <h3 class="font-semibold text-gray-900">
                                                        Nouvelle réservation
                                                    </h3>

                                                @elseif ($type === 'reservation_accepted')
                                                    <h3 class="font-semibold text-gray-900">
                                                        Réservation acceptée
                                                    </h3>

                                                @elseif ($type === 'reservation_refused')
                                                    <h3 class="font-semibold text-gray-900">
                                                        Réservation refusée
                                                    </h3>

                                                @elseif ($type === 'reservation_completed')
                                                    <h3 class="font-semibold text-gray-900">
                                                        Réservation terminée
                                                    </h3>

                                                @else
                                                    <h3 class="font-semibold text-gray-900">
                                                        Notification
                                                    </h3>
                                                @endif

                                                <p class="mt-1 text-sm text-gray-600">
                                                    {{ $message }}
                                                </p>

                                            </div>

                                            @if (!$notification->read_at)
                                                <span class="inline-flex w-fit rounded-full bg-indigo-100 px-2.5 py-1 text-xs font-medium text-indigo-700">
                                                    Nouveau
                                                </span>
                                            @endif

                                        </div>

                                        <div class="mt-3 flex flex-wrap items-center gap-3">

                                            <span class="text-xs text-gray-400">
                                                {{ $notification->created_at->format('d/m/Y à H:i') }}
                                            </span>

                                            @if (!$notification->read_at)

                                                <form method="POST"
                                                      action="{{ route('notifications.read', $notification) }}">

                                                    @csrf
                                                    @method('PATCH')

                                                    <button type="submit"
                                                            class="text-xs font-medium text-indigo-600 hover:text-indigo-800">
                                                        Marquer comme lu
                                                    </button>

                                                </form>

                                            @endif

                                            @if ($type === 'new_message' && isset($data['conversation_id']))

                                                <a href="{{ route('conversations.show', $data['conversation_id']) }}"
                                                   class="text-xs font-medium text-gray-600 hover:text-gray-900">
                                                    Voir la conversation →
                                                </a>

                                            @elseif (isset($data['reservation_id']))

                                                <a href="{{ route('reservations.show', $data['reservation_id']) }}"
                                                   class="text-xs font-medium text-gray-600 hover:text-gray-900">
                                                    Voir la réservation →
                                                </a>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

                <div class="mt-6">
                    {{ $notifications->links() }}
                </div>

            @else

                <div class="rounded-xl bg-white p-12 text-center shadow-sm">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                        <span class="text-3xl">🔔</span>
                    </div>

                    <h3 class="mt-5 text-lg font-semibold text-gray-900">
                        Aucune notification
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Vous n'avez aucune nouvelle notification.
                    </p>

                </div>

            @endif

        </div>
    </div>

</x-app-layout>