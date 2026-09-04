<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Avis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 rounded-lg bg-green-100 p-4 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">

                    @if ($avis->count() > 0)

                        <div class="space-y-6">

                            @foreach ($avis as $avi)
                                <div class="border rounded-lg p-5">

                                    <div class="flex justify-between items-start gap-4">

                                        <div>
                                            <h3 class="font-semibold text-lg text-gray-900">
                                                {{ $avi->service->titre }}
                                            </h3>

                                            <p class="text-sm text-gray-500 mt-1">
                                                Par {{ $avi->user->prenom }} {{ $avi->user->nom }}
                                            </p>
                                        </div>

                                        <div class="text-yellow-500 font-semibold">
                                            {{ $avi->note }}/5 ★
                                        </div>

                                    </div>

                                    @if ($avi->commentaire)
                                        <p class="mt-4 text-gray-700">
                                            {{ $avi->commentaire }}
                                        </p>
                                    @endif

                                    <p class="mt-4 text-sm text-gray-500">
                                        {{ $avi->date?->format('d/m/Y H:i') }}
                                    </p>

                                </div>
                            @endforeach

                        </div>

                        <div class="mt-6">
                            {{ $avis->links() }}
                        </div>

                    @else

                        <div class="text-center py-12">
                            <h3 class="text-lg font-semibold text-gray-900">
                                Aucun avis
                            </h3>

                            <p class="mt-2 text-gray-500">
                                Aucun avis n'est disponible pour le moment.
                            </p>
                        </div>

                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>