<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::query()
            ->when($request->search, function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->role, fn ($q, $role) => $q->where('role', $role))
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function toggleActive(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return back()->with('info', 'Anda tidak dapat menonaktifkan akun sendiri.');
        }

        if ($user->role === 'admin') {
            return back()->with('info', 'Anda tidak dapat mengubah status admin lain.');
        }

        $user->forceFill(['is_active' => ! $user->is_active])->save();

        ActivityLog::log('toggle_active', 'users', "Toggled active status for user {$user->name} ({$user->email})", ['user_id' => $user->id, 'is_active' => $user->is_active]);

        return back()->with('status', $user->is_active ? 'user-activated' : 'user-deactivated');
    }
}
