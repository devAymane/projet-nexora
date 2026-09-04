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
            'categories' => Category::count(),
            'reservations' => Reservation::count(),
            'reviews' => Avis::count(),
        ];

        return view('dashboards.admin', compact('stats'));
    }
}