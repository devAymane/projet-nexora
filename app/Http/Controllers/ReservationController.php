<?php

namespace App\Http\Controllers;

use App\Events\ReservationAccepted;
use App\Events\ReservationCompleted;
use App\Events\ReservationCreated;
use App\Events\ReservationRefused;
use App\Http\Requests\StoreReservationRequest;
use App\Models\Reservation;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Reservation::class);

        $user = $request->user();

        $query = Reservation::with([
            'user',
            'service.category',
            'service.user',
        ]);

        if ($user->hasRole('provider')) {
            $query->whereHas('service', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        } else {
            $query->where('user_id', $user->id);
        }

        $reservations = $query
            ->latest('date')
            ->paginate(10);

        return view('reservations.index', compact('reservations'));
    }

    public function create(): View
    {
        $this->authorize('create', Reservation::class);

        $services = Service::with('category')
            ->where('statut', 'publie')
            ->where('disponibilite', true)
            ->latest()
            ->get();

        return view('reservations.create', compact('services'));
    }

public function store(StoreReservationRequest $request): RedirectResponse
{
    $this->authorize('create', Reservation::class);

    $reservation = Reservation::create([
        'user_id' => $request->user()->id,
        'service_id' => $request->validated('service_id'),
        'date' => $request->validated('date'),
        'message' => $request->validated('message'),
        'statut' => 'en_attente',
    ]);

    event(new ReservationCreated($reservation));

    return redirect()
        ->route('reservations.index')
        ->with('success', 'Réservation créée avec succès.');
}



    public function show(Reservation $reservation): View
    {
        $this->authorize('view', $reservation);

        $reservation->load([
            'user',
            'service.category',
            'service.user',
            'avis',
        ]);

        return view('reservations.show', compact('reservation'));
    }

    public function cancel(Reservation $reservation): RedirectResponse
    {
        $this->authorize('delete', $reservation);

        if ($reservation->statut !== 'en_attente') {
            return back()->with(
                'error',
                'Cette réservation ne peut plus être annulée.'
            );
        }

        $reservation->update([
            'statut' => 'annulee',
        ]);

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Réservation annulée avec succès.');
    }

    public function accept(Reservation $reservation): RedirectResponse
    {
        $this->authorize('manage', $reservation);

        if ($reservation->statut !== 'en_attente') {
            return back()->with(
                'error',
                'Cette réservation ne peut plus être acceptée.'
            );
        }

        $reservation->update([
            'statut' => 'acceptee',
        ]);

        event(new ReservationAccepted($reservation));

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Réservation acceptée avec succès.');
    }

    public function refuse(Reservation $reservation): RedirectResponse
    {
        $this->authorize('manage', $reservation);

        if ($reservation->statut !== 'en_attente') {
            return back()->with(
                'error',
                'Cette réservation ne peut plus être refusée.'
            );
        }

        $reservation->update([
            'statut' => 'refusee',
        ]);

        event(new ReservationRefused($reservation));

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Réservation refusée avec succès.');
    }

    public function complete(Reservation $reservation): RedirectResponse
    {
        $this->authorize('manage', $reservation);

        if ($reservation->statut !== 'acceptee') {
            return back()->with(
                'error',
                'Seule une réservation acceptée peut être marquée comme terminée.'
            );
        }

        $reservation->update([
            'statut' => 'terminee',
        ]);

        event(new ReservationCompleted($reservation));

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Réservation marquée comme terminée.');
    }
}