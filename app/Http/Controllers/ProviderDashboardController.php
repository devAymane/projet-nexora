<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProviderDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $stats = [
            'services' => Service::where('user_id', $user->id)->count(),

            'pending' => Reservation::whereHas('service', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('statut', 'en_attente')->count(),

            'accepted' => Reservation::whereHas('service', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('statut', 'acceptee')->count(),

            'completed' => Reservation::whereHas('service', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('statut', 'terminee')->count(),
        ];

        $recentReservations = Reservation::with(['user', 'service'])
            ->whereHas('service', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->latest('date')
            ->limit(5)
            ->get();

        return view('dashboards.provider', compact(
            'stats',
            'recentReservations'
        ));
    }
}