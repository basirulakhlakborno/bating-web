<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\User;
use App\Models\UserDeposit;
use App\Models\UserWithdrawal;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'players' => User::count(),
            'games' => Game::count(),
            'deposits_pending' => UserDeposit::where('status', 'pending')->count(),
            'withdrawals_pending' => UserWithdrawal::where('status', 'pending')->count(),
        ];

        $recentDeposits = UserDeposit::with('user')->latest()->limit(5)->get();
        $recentWithdrawals = UserWithdrawal::with('user')->latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentDeposits', 'recentWithdrawals'));
    }
}
