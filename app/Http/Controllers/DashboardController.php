<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function __invoke(): Response
    {
        return Inertia::render('dashboard', [
            'stats' => [
                'totalUsers' => User::count(),
                'newThisMonth' => User::where('created_at', '>=', now()->startOfMonth())->count(),
            ],
            'recentUsers' => User::latest()->take(5)->get(['id', 'name', 'email', 'created_at']),
        ]);
    }
}
