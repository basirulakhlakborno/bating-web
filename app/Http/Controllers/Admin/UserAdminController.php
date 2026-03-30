<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserAdminController extends Controller
{
    public function index(): View
    {
        $users = User::query()->orderByDesc('id')->limit(200)->get();

        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'role' => ['required', 'in:user,admin'],
        ]);

        if ($user->id === $request->user()->id && $request->input('role') !== 'admin') {
            return redirect()->back()->withErrors(['role' => 'You cannot remove your own admin role.']);
        }

        $user->update(['role' => $request->input('role')]);

        return redirect()->route('admin.users.index')->with('status', 'User role updated.');
    }
}
