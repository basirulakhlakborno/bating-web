<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminMessage;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageAdminController extends Controller
{
    public function index(): View
    {
        $messages = AdminMessage::with('user')
            ->latest('sent_at')
            ->paginate(50);

        return view('admin.messages.index', compact('messages'));
    }

    public function create(): View
    {
        return view('admin.messages.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'recipient' => ['required', 'string', 'in:all,single'],
            'username' => ['required_if:recipient,single', 'nullable', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:5000'],
        ]);

        if ($data['recipient'] === 'single') {
            $user = User::query()->where('username', $data['username'])->first();
            if (! $user) {
                return redirect()->back()->withInput()->withErrors(['username' => 'Player not found.']);
            }

            AdminMessage::create([
                'user_id' => $user->id,
                'title' => $data['title'],
                'body' => $data['body'],
                'sent_at' => now(),
            ]);

            return redirect()->route('admin.messages.index')->with('status', "Message sent to {$user->username}.");
        }

        $userIds = User::query()->pluck('id');
        $rows = $userIds->map(fn ($id) => [
            'user_id' => $id,
            'title' => $data['title'],
            'body' => $data['body'],
            'sent_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ])->toArray();

        foreach (array_chunk($rows, 500) as $chunk) {
            AdminMessage::insert($chunk);
        }

        return redirect()->route('admin.messages.index')
            ->with('status', "Message sent to all {$userIds->count()} players.");
    }

    public function destroy(AdminMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()->route('admin.messages.index')->with('status', 'Message deleted.');
    }
}
