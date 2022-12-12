<?php

namespace App\Http\Controllers;

use App\Events\BroadcastChat;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => ['required']
        ]);

        $validated['user_id'] = auth()->id();

        $chat = Chat::create($validated);

        BroadcastChat::dispatch($chat);

        return [
            'success' => true,
        ];
    }
}
