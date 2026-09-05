<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Reservation;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProviderDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $serviceIds = Service::where('user_id', $user->id)->pluck('id');

        $providerReservations = Reservation::whereIn('service_id', $serviceIds);

        $stats = [
            'services' => Service::where('user_id', $user->id)->count(),

            'pending' => (clone $providerReservations)
                ->where('statut', 'en_attente')
                ->count(),

            'accepted' => (clone $providerReservations)
                ->where('statut', 'acceptee')
                ->count(),

            'completed' => (clone $providerReservations)
                ->where('statut', 'terminee')
                ->count(),

            'reviews' => Avis::whereIn('service_id', $serviceIds)->count(),

            'rating' => round(
                Avis::whereIn('service_id', $serviceIds)->avg('note') ?? 0,
                1
            ),
        ];

        $recentReservations = Reservation::with(['user', 'service'])
            ->whereIn('service_id', $serviceIds)
            ->latest('date')
            ->limit(5)
            ->get();

        return view('dashboards.provider', compact(
            'stats',
            'recentReservations'
        ));
    }
}