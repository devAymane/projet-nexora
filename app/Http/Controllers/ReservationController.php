<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Reservation;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReservationController extends Controller
{
    /**
     * Afficher les réservations de l'utilisateur connecté.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Reservation::class);

        $user = $request->user();

        if ($user->hasRole('provider')) {
            $reservations = Reservation::with(['user', 'service'])
                ->whereHas('service', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->latest('date')
                ->paginate(10);
        } else {
            $reservations = Reservation::with(['user', 'service'])
                ->where('user_id', $user->id)
                ->latest('date')
                ->paginate(10);
        }

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Afficher le formulaire de création.
     */
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

    /**
     * Enregistrer une nouvelle réservation.
     */
    public function store(
        StoreReservationRequest $request
    ): RedirectResponse {
        $this->authorize('create', Reservation::class);

        Reservation::create([
            'user_id' => $request->user()->id,
            'service_id' => $request->validated('service_id'),
            'date' => $request->validated('date'),
            'message' => $request->validated('message'),
            'statut' => 'en_attente',
        ]);

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Réservation créée avec succès.');
    }

    /**
     * Afficher une réservation.
     */
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

    /**
     * Annuler une réservation par le client.
     */
    public function cancel(Reservation $reservation): RedirectResponse
    {
        $this->authorize('delete', $reservation);

        if ($reservation->statut !== 'en_attente') {
            return back()->with('error', 'Cette réservation ne peut plus être annulée.');
        }

        $reservation->update([
            'statut' => 'annulee',
        ]);

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Réservation annulée avec succès.');
    }

    /**
     * Accepter une réservation par le provider.
     */
    public function accept(Reservation $reservation): RedirectResponse
    {
        $this->authorize('manage', $reservation);

        if ($reservation->statut !== 'en_attente') {
            return back()->with('error', 'Cette réservation ne peut plus être acceptée.');
        }

        $reservation->update([
            'statut' => 'acceptee',
        ]);

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Réservation acceptée avec succès.');
    }

    /**
     * Refuser une réservation par le provider.
     */
    public function refuse(Reservation $reservation): RedirectResponse
    {
        $this->authorize('manage', $reservation);

        if ($reservation->statut !== 'en_attente') {
            return back()->with('error', 'Cette réservation ne peut plus être refusée.');
        }

        $reservation->update([
            'statut' => 'refusee',
        ]);

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Réservation refusée avec succès.');
    }

    /**
     * Marquer une réservation comme terminée.
     */
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

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Réservation marquée comme terminée.');
    }
}