<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Favorite::class);

        $favorites = Favorite::with([
            'service.category',
            'service.user',
        ])
            ->where('user_id', $request->user()->id)
            ->latest('date')
            ->paginate(12);

        return view('favorites.index', compact('favorites'));
    }

    public function store(Request $request, Service $service): RedirectResponse
    {
        Gate::authorize('create', Favorite::class);

        Favorite::firstOrCreate(
            [
                'user_id' => $request->user()->id,
                'service_id' => $service->id,
            ],
            [
                'date' => now(),
            ]
        );

        return back()->with('success', 'Service ajouté aux favoris.');
    }

    public function destroy(Request $request, Service $service): RedirectResponse
    {
        $favorite = Favorite::where('user_id', $request->user()->id)
            ->where('service_id', $service->id)
            ->firstOrFail();

        Gate::authorize('delete', $favorite);

        $favorite->delete();

        return back()->with('success', 'Service retiré des favoris.');
    }
}