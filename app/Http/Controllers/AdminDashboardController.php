<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Category;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'users' => User::count(),

            'services' => Service::count(),

            'publishedServices' => Service::where('statut', 'publie')
                ->count(),

            'categories' => Category::count(),

            'reservations' => Reservation::count(),

            'pendingReservations' => Reservation::where('statut', 'en_attente')
                ->count(),

            'completedReservations' => Reservation::where('statut', 'terminee')
                ->count(),

            'reviews' => Avis::count(),
        ];

        $recentReservations = Reservation::with([
            'user',
            'service',
            'service.user',
        ])
            ->latest('created_at')
            ->limit(8)
            ->get();

        return view('dashboards.admin', compact(
            'stats',
            'recentReservations'
        ));
    }
}