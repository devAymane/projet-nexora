<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAvisRequest;
use App\Models\Avis;
use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AvisController extends Controller
{
    /**
     * Display the avis list.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Avis::class);

        $user = $request->user();

        if ($user->hasRole('admin')) {
            $avis = Avis::with(['user', 'service'])
                ->latest('date')
                ->paginate(10);
        } elseif ($user->hasRole('client')) {
            $avis = Avis::with(['user', 'service'])
                ->where('user_id', $user->id)
                ->latest('date')
                ->paginate(10);
        } elseif ($user->hasRole('provider')) {
            $avis = Avis::with(['user', 'service'])
                ->whereHas('service', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->latest('date')
                ->paginate(10);
        } else {
            abort(403);
        }

        return view('avis.index', compact('avis'));
    }

    /**
     * Show the form to create an avis.
     */
    public function create(Reservation $reservation): View
    {
        $this->authorize('create', [Avis::class, $reservation]);

        $reservation->load([
            'service.category',
            'service.user',
        ]);

        return view('avis.create', compact('reservation'));
    }

    /**
     * Store a new avis.
     */
    public function store(StoreAvisRequest $request): RedirectResponse
    {
        $reservation = Reservation::with('service')->findOrFail(
            $request->validated('reservation_id')
        );

        $this->authorize('create', [Avis::class, $reservation]);

        Avis::create([
            'reservation_id' => $reservation->id,
            'user_id' => $request->user()->id,
            'service_id' => $reservation->service_id,
            'note' => $request->validated('note'),
            'commentaire' => $request->validated('commentaire'),
            'date' => now(),
        ]);

        return redirect()
            ->route('reservations.show', $reservation)
            ->with('success', 'Votre avis a été ajouté avec succès.');
    }
}