<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all();
        $chats = Chat::with(['user'])->latest()->get();

        return view('dashboard', [
            'users' => $users,
            'chats' => $chats,
        ]);
    }
}
