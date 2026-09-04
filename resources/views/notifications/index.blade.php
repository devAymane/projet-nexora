<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            <div class="mb-8 flex items-center justify-between gap-4">

                <div>
                    <h1 class="text-3xl font-bold text-slate-900">
                        Notifications
                    </h1>

                    <p class="mt-2 text-sm text-slate-500">
                        Retrouvez toutes vos notifications.
                    </p>
                </div>

                @if(auth()->user()->unreadNotifications->count())
                    <form
                        method="POST"
                        action="{{ route('notifications.readAll') }}"
                    >
                        @csrf
                        @method('PATCH')

                        <button
                            type="submit"
                            class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700"
                        >
                            Tout marquer comme lu
                        </button>
                    </form>
                @endif

            </div>

            @if(session('success'))
                <div class="mb-6 rounded-xl bg-green-50 p-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if($notifications->count())

                <div class="space-y-3">

                    @foreach($notifications as $notification)

                        @php
                            $data = $notification->data;
                        @endphp

                        <div
                            class="rounded-2xl border p-5 shadow-sm
                            {{ $notification->read_at
                                ? 'border-slate-200 bg-white'
                                : 'border-indigo-200 bg-indigo-50'
                            }}"
                        >

                            <div class="flex items-start justify-between gap-4">

                                <div class="flex gap-4">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-lg">
                                        🔔
                                    </div>

                                    <div>

                                        <h2 class="font-semibold text-slate-900">
                                            {{ $data['message'] ?? 'Nouvelle notification' }}
                                        </h2>

                                        <p class="mt-1 text-xs text-slate-500">
                                            {{ $notification->created_at->format('d/m/Y H:i') }}
                                        </p>

                                    </div>

                                </div>

                                @if(!$notification->read_at)

                                    <form
                                        method="POST"
                                        action="{{ route('notifications.read', $notification) }}"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="text-sm font-medium text-indigo-600 hover:text-indigo-800"
                                        >
                                            Marquer comme lu
                                        </button>
                                    </form>

                                @else

                                    <span class="text-xs text-slate-400">
                                        Lu
                                    </span>

                                @endif

                            </div>

                        </div>

                    @endforeach

                </div>

                <div class="mt-6">
                    {{ $notifications->links() }}
                </div>

            @else

                <div class="rounded-2xl border border-slate-200 bg-white p-12 text-center">

                    <div class="text-5xl">
                        🔔
                    </div>

                    <h2 class="mt-4 text-xl font-bold text-slate-900">
                        Aucune notification
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">
                        Vous n'avez aucune notification pour le moment.
                    </p>

                </div>

            @endif

        </div>
    </div>

</x-app-layout>