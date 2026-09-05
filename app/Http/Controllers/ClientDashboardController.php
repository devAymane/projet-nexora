<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $stats = [
            'reservations' => Reservation::where('user_id', $user->id)->count(),

            'pending' => Reservation::where('user_id', $user->id)
                ->where('statut', 'en_attente')
                ->count(),

            'accepted' => Reservation::where('user_id', $user->id)
                ->where('statut', 'acceptee')
                ->count(),

            'completed' => Reservation::where('user_id', $user->id)
                ->where('statut', 'terminee')
                ->count(),

            'favorites' => Favorite::where('user_id', $user->id)->count(),
        ];

        $recentReservations = Reservation::with([
            'service.category',
            'service.user',
        ])
            ->where('user_id', $user->id)
            ->latest('date')
            ->limit(5)
            ->get();

        $recentFavorites = Favorite::with([
            'service.category',
            'service.user',
        ])
            ->where('user_id', $user->id)
            ->latest('date')
            ->limit(4)
            ->get();

        return view('dashboards.client', compact(
            'stats',
            'recentReservations',
            'recentFavorites'
        ));
    }
}