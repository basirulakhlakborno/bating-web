<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserDeposit;
use App\Models\UserWithdrawal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionAdminController extends Controller
{
    public function deposits(Request $request): View
    {
        $query = UserDeposit::with('user')->latest();

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                  ->orWhereHas('user', fn ($u) => $u->where('username', 'like', "%{$search}%"));
            });
        }

        $deposits = $query->paginate(50)->withQueryString();

        return view('admin.transactions.deposits', compact('deposits'));
    }

    public function updateDepositStatus(Request $request, UserDeposit $deposit): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'string', 'in:pending,approved,rejected'],
        ]);

        $deposit->update(['status' => $data['status']]);

        return redirect()->back()->with('status', "Deposit #{$deposit->id} marked as {$data['status']}.");
    }

    public function withdrawals(Request $request): View
    {
        $query = UserWithdrawal::with('user')->latest();

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                  ->orWhere('account_phone', 'like', "%{$search}%")
                  ->orWhereHas('user', fn ($u) => $u->where('username', 'like', "%{$search}%"));
            });
        }

        $withdrawals = $query->paginate(50)->withQueryString();

        return view('admin.transactions.withdrawals', compact('withdrawals'));
    }

    public function updateWithdrawalStatus(Request $request, UserWithdrawal $withdrawal): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'string', 'in:pending,approved,rejected'],
        ]);

        $withdrawal->update(['status' => $data['status']]);

        return redirect()->back()->with('status', "Withdrawal #{$withdrawal->id} marked as {$data['status']}.");
    }
}
