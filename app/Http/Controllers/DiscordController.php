<?php

namespace App\Http\Controllers;

use App\Models\DiscordInvite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DiscordController extends Controller
{

    public function show()
    {
        $invite = DiscordInvite::where('user_id', Auth::id())->orderBy('created_at', 'DESC')->first();
        if ($invite) {
            return view('discord.show', [
                'invite' => $invite,
            ]);
        } else {
            return view('discord.create');
        }
    }

    public function store()
    {
        DiscordInvite::create([
            'user_id' => Auth::id(),
            'sent' => false,
        ]);

        return redirect()->route('discord.show');
    }
}
