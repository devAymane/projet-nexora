<x-app-layout>
    <div class="min-h-screen bg-slate-50 py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <div class="mb-2 flex items-center gap-2 text-sm text-slate-500">
                        <a
                            href="{{ route('dashboard') }}"
                            class="transition hover:text-indigo-600"
                        >
                            Dashboard
                        </a>

                        <span>/</span>
                        <span>Notifications</span>
                    </div>

                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                        Notifications
                    </h1>

                    <p class="mt-2 text-sm text-slate-500">
                        Retrouvez toutes vos notifications et mises à jour.
                    </p>
                </div>

                {{-- Unread counter --}}
                @if(auth()->user()->unreadNotifications->count())
                    <div class="inline-flex w-fit items-center gap-2 rounded-xl bg-indigo-50 px-4 py-2 text-sm font-semibold text-indigo-700">
                        <span class="h-2.5 w-2.5 rounded-full bg-indigo-600"></span>
                        {{ auth()->user()->unreadNotifications->count() }}
                        non lue{{ auth()->user()->unreadNotifications->count() > 1 ? 's' : '' }}
                    </div>
                @endif
            </div>

            {{-- Success --}}
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 rounded-2xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-green-100">
                        ✓
                    </span>

                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($notifications->count())

                {{-- Actions --}}
                @if(auth()->user()->unreadNotifications->count())
                    <div class="mb-4 flex justify-end">
                        <form
                            method="POST"
                            action="{{ route('notifications.read-all') }}"
                        >
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700"
                            >
                                <span>✓✓</span>
                                Tout marquer comme lu
                            </button>
                        </form>
                    </div>
                @endif

                {{-- Notifications list --}}
                <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                    <div class="divide-y divide-slate-100">

                        @foreach($notifications as $notification)

                            @php
                                $data = $notification->data ?? [];

                                $type = $data['type'] ?? 'notification';

                                $message = $data['message']
                                    ?? 'Vous avez une nouvelle notification.';

                                $isUnread = is_null($notification->read_at);

                                $title = match($type) {
                                    'new_message' => 'Nouveau message',
                                    'reservation_created' => 'Nouvelle réservation',
                                    'reservation_accepted' => 'Réservation acceptée',
                                    'reservation_refused' => 'Réservation refusée',
                                    'reservation_completed' => 'Réservation terminée',
                                    default => 'Notification',
                                };

                                $icon = match($type) {
                                    'new_message' => '💬',
                                    'reservation_created' => '📅',
                                    'reservation_accepted' => '✅',
                                    'reservation_refused' => '❌',
                                    'reservation_completed' => '🎉',
                                    default => '🔔',
                                };
                            @endphp

                            <div
                                class="{{ $isUnread ? 'bg-indigo-50/50' : 'bg-white' }} p-5 transition hover:bg-slate-50 sm:p-6"
                            >
                                <div class="flex items-start gap-4">

                                    {{-- Icon --}}
                                    <div
                                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl {{ $isUnread ? 'bg-indigo-100' : 'bg-slate-100' }}"
                                    >
                                        <span class="text-xl">
                                            {{ $icon }}
                                        </span>
                                    </div>

                                    {{-- Content --}}
                                    <div class="min-w-0 flex-1">

                                        <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">

                                            <div class="min-w-0">
                                                <div class="flex items-center gap-2">
                                                    <h2 class="font-semibold text-slate-900">
                                                        {{ $title }}
                                                    </h2>

                                                    @if($isUnread)
                                                        <span class="h-2 w-2 rounded-full bg-indigo-600"></span>
                                                    @endif
                                                </div>

                                                <p class="mt-1 text-sm leading-6 text-slate-600">
                                                    {{ $message }}
                                                </p>
                                            </div>

                                            @if($isUnread)
                                                <span class="inline-flex w-fit shrink-0 rounded-full bg-indigo-100 px-2.5 py-1 text-xs font-semibold text-indigo-700">
                                                    Nouveau
                                                </span>
                                            @endif

                                        </div>

                                        {{-- Footer --}}
                                        <div class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-2">

                                            <span class="text-xs text-slate-400">
                                                {{ $notification->created_at?->format('d/m/Y à H:i') }}
                                            </span>

                                            @if($isUnread)
                                                <form
                                                    method="POST"
                                                    action="{{ route('notifications.read', $notification) }}"
                                                >
                                                    @csrf
                                                    @method('PATCH')

                                                    <button
                                                        type="submit"
                                                        class="text-xs font-semibold text-indigo-600 transition hover:text-indigo-800"
                                                    >
                                                        Marquer comme lu
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-xs font-medium text-green-600">
                                                    ✓ Lu
                                                </span>
                                            @endif

                                            {{-- Related resource --}}
                                            @if($type === 'new_message' && isset($data['conversation_id']))

                                                <a
                                                    href="{{ route('conversations.show', $data['conversation_id']) }}"
                                                    class="text-xs font-semibold text-slate-600 transition hover:text-indigo-600"
                                                >
                                                    Voir la conversation →
                                                </a>

                                            @elseif(isset($data['reservation_id']))

                                                <a
                                                    href="{{ route('reservations.show', $data['reservation_id']) }}"
                                                    class="text-xs font-semibold text-slate-600 transition hover:text-indigo-600"
                                                >
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

                {{-- Pagination --}}
                @if($notifications->hasPages())
                    <div class="mt-8">
                        {{ $notifications->links() }}
                    </div>
                @endif

            @else

                {{-- Empty state --}}
                <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                    <div class="px-6 py-16 text-center sm:px-12">

                        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-indigo-50 text-4xl">
                            🔔
                        </div>

                        <h2 class="mt-6 text-xl font-bold text-slate-900">
                            Aucune notification
                        </h2>

                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                            Vous n'avez aucune notification pour le moment.
                            Les nouvelles réservations, messages et mises à jour
                            apparaîtront ici.
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