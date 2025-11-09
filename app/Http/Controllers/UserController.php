<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(25)->withQueryString();
        $active = 'All';

        if (request()->has('friends')) {
            $users = Auth::user()->following()
                ->orderBy('user_follows.pinned', 'desc')
                ->orderBy('users.name', 'asc')
                ->paginate(25)
                ->withQueryString();
            $active = 'Friends';
        }
        return view('users.index', [
            'users' => $users,
            'active' => $active,
        ]);
    }

    public function show(User $user)
    {
        return view('users.show', [
            'user' => $user,
        ]);
    }
}
